<?php
require_once './FAQService.php';

$faqService = new FAQService();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $action = $_POST['action'] ?? '';
        switch ($action) {
            case $faqService::ACTION_CREATE:
                $question = $_POST['question'] ?? '';
                $answer   = $_POST['answer'] ?? '';
                $active   = $_POST['active'] ?? '1';

                $faqService->createFaq($question, $answer, $active);
                $message = 'Pergunta cadastrada com sucesso!';
                header('Location: admin.php?success=1&message='. urlencode($message));                
                break;

            case $faqService::ACTION_EDIT:
                    $id = $_POST['id'] ?? '';
                    $result = $faqService->updateFaq($_POST);
                    if (empty($result)) {
                        throw new \Exception('Não foi possível atualizar a pergunta');
                    }

                    $message = 'Pergunta alterada com sucesso!';
                    header('Location: admin.php?success=1&message='. urlencode($message));                    
                    break;
                
            case $faqService::ACTION_DELETE:
                $id = $_POST['id'] ?? '';
                $faqService->deleteFaq($id);
                $message = 'Pergunta excluida com sucesso!';
                header('Location: admin.php?success=1&message='. urlencode($message));
                break;
                
            default: throw new Exception("Opção inválida!");
        }
    } catch (\Exception $e) {
        $message = $e->getMessage();
        header('Location: admin.php?error=1&message='. urlencode($message));
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel FAQ</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@mdi/font@7.4.47/css/materialdesignicons.min.css" />
</head>
<body>
    <div class="container py-5">
        <?php 
            $data = [];
            if (isset($_GET['action'])) {
                if ($_GET['action'] === $faqService::ACTION_EDIT || $_GET['action'] === $faqService::ACTION_DELETE) {
                    $data = $faqService->getFaqById($_GET['faq_id']);
                    if (empty($data)) {
                        echo '<h1>Registro não encontrada!</h1>',
                            '<a href="admin.php">Deseja voltar?</a>';
                        exit;
                    }
                }

                if (!in_array($_GET['action'], $faqService::ACTIONS)) {
                    echo '<h1>Ação inválida!</h1>',
                         '<a href="admin.php">Deseja voltar?</a>';
                    exit;
                }
                
                $readOnly = '';
                if ($_GET['action'] === $faqService::ACTION_DELETE) {
                    $readOnly = 'readonly';
                }
                // echo '<pre>', print_r($data, true), '</pre>';
            }


            $action     = $_GET['action'] ?? '';
            $id         = $data['id'] ?? '';
            $question   = $data['question'] ?? '';
            $answer     = $data['answer'] ?? '';
            $active     = $data['active'] ?? '1';
            // $created_at = $data['created_at'] ?? '';
            // $updated_at = $data['updated_at'] ?? '';

            $message = isset($_GET['message']) ? urldecode($_GET['message']) : '';
        ?>

        <!-- Title -->
        <?php if (!isset($_GET['action'])): ?>
            <h2 class="mb-2">Listagem de Perguntas</h2>
        <?php elseif (isset($_GET['action']) && $_GET['action'] === $faqService::ACTION_CREATE): ?>
            <h2 class="mb-4">Cadastrar uma Nova Pergunta</h2>
        <?php elseif (isset($_GET['action']) && $_GET['action'] === $faqService::ACTION_EDIT): ?>
            <h2 class="mb-4">Editar Pergunta</h2>
        <?php elseif (isset($_GET['action']) && $_GET['action'] === $faqService::ACTION_DELETE): ?>
            <h2 class="mb-4">Excluir Pergunta</h2>
        <?php endif; ?>


        <!-- Alerts -->
        <?php if (isset($_GET['success'])): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= $message ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php endif; ?>

        <?php if (isset($_GET['action']) && $_GET['action'] === $faqService::ACTION_DELETE): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <b class="fs-3">Aviso!</b> 
            <span class="d-block">Você está prestes á excluir essa pergunta! Uma vez excluída ela não poderá ser recuperada!</span>
            <button type="button" class="btn-close outline-none" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php endif; ?>

        <?php if (isset($_GET['error'])): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <b>Ops!</b> Ocorreu um erro internamente e por isso não foi possivel realizar o processo dessa pergunta!
            <button type="button" class="btn-close outline-none" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php endif; ?>


        <!-- Forms -->
        <?php if (isset($_GET['action'])): ?>            

            <form method="post" action="" class="needs-validation" onsubmit="return validate(this);" novalidate>
                <input type="hidden" name="id" value="<?= $id ?>" />
                <input type="hidden" name="action" value="<?= $action ?>" />

                <div class="mb-3">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="active" id="active-on" value="1" <?= ($active == '1') ? 'checked' : '' ?> <?= $readOnly ?> />
                        <label class="form-check-label" for="active-on">
                            Ativo
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="active" id="active-off" value="0" <?= ($active == '0') ? 'checked' : '' ?> <?= $readOnly ?> />
                        <label class="form-check-label" for="active-off">
                            Inativo
                        </label>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="question" class="form-label">Pergunta</label>
                    <textarea class="form-control" id="question" name="question" rows="2" <?= $readOnly ?> required><?= $question ?></textarea>
                    <div class="invalid-feedback">Este campo é obrigatório!</div>
                </div>

                <div class="mb-3">
                    <label for="answer" class="form-label">Resposta</label>
                    <textarea class="form-control" id="answer" name="answer" rows="4" <?= $readOnly ?> required><?= $answer ?></textarea>
                    <div class="invalid-feedback">Este campo é obrigatório!</div>
                </div>

                <!-- Button's -->
                <?php if (isset($_GET['action']) && $_GET['action'] === $faqService::ACTION_CREATE): ?>

                    <button type="submit" class="btn btn-primary px-4 d-flex align-items-center align-content-center gap-2">
                        <span class="mdi mdi-plus mdi-24px"></span>
                        <span class="fw-semibold">Cadastrar</span>
                    </button>

                <?php elseif (isset($_GET['action']) && $_GET['action'] === $faqService::ACTION_EDIT): ?>

                    <button type="submit" class="btn btn-success px-4 d-flex align-items-center align-content-center gap-2">
                        <span class="mdi mdi-content-save-edit mdi-24px"></span>
                        <span class="fw-semibold">Editar</span>
                    </button>

                <?php elseif (isset($_GET['action']) && $_GET['action'] === $faqService::ACTION_DELETE): ?>

                    <button type="submit" class="btn btn-danger px-4 d-flex align-items-center align-content-center gap-2">
                        <span class="mdi mdi-close mdi-24px"></span>
                        <span class="fw-semibold">Deletar</span>
                    </button>

                <?php endif; ?>
            </form>

        <?php else: ?>
            
            <a class="btn btn-primary mb-4 px-4" href="admin.php?action=create">
                <span class="align-middle mdi mdi-plus mdi-24px"></span>
                <span class="align-middle fw-semibold">Cadastrar Nova Pergunta</span>
            </a>
            <table class="table">
                <thead>
                    <tr>
                        <th class="text-center" style="width: 5%">#</th>
                        <th class="text-left" style="width: 30%">Pergunta</th>
                        <th class="text-left" style="width: 40%">Resposta</th>
                        <th class="text-center" style="width: 5%">Ativo</th>
                        <th class="text-center" style="width: 10%">Criado em</th>
                        <th class="text-center" style="width: 10%">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($faqService->listFaq() as $faq): ?>
                        <tr>
                            <td class="text-center"><?= $faq['id'] ?></td>
                            <td class="text-left"><?= $faq['question'] ?></td>
                            <td class="text-left"><?= $faq['answer'] ?></td>
                            <td class="text-center">
                                <?php if ($faq['active'] == 1): ?>
                                    <div class="mdi mdi-check mdi-24px text-success"></div>
                                <?php else: ?>
                                    <div class="mdi mdi-close mdi-24px text-danger"></div>
                                <?php endif;
                                ?>
                            </td>
                            <td class="text-center"><?php echo date('d/m/Y H:i:s', strtotime($faq['created_at'])); ?></td>
                            <td class="text-center">
                                <a href="admin.php?action=edit&faq_id=<?= $faq['id'] ?>" class="btn btn-success" title="Editar">
                                    <span class="mdi mdi-pencil"></span>
                                </a>
                                <a href="admin.php?action=delete&faq_id=<?= $faq['id'] ?>" class="btn btn-danger" title="Deletar">
                                    <span class="mdi mdi-trash-can"></span>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

        <?php endif; ?>
    </div>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        function validate(form) {
            if (form.action.value !== 'delete' && form.question.value === '' || form.answer.value === false) {
                event.preventDefault();
                event.stopPropagation();
            }
            form.classList.add('was-validated');
        }
    </script>
</body>
</html>