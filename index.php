<?php
    require_once './FAQService.php';
    
    $faqService = new FAQService();
    $faqs = $faqService->getAllFaqs();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FAQ</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@mdi/font@7.4.47/css/materialdesignicons.min.css" />
    <style>
        body { 
            background: #f8fafc; 
            font-family: Arial, sans-serif; 
        }
        .faq-card { 
            margin-bottom: 1rem; 
            border-left: 4px solid #0d6efd; 
            border-radius: .25rem; 
            background: #ffffff; 
            box-shadow: 0 1px 3px rgba(0,0,0,0.1); 
        }
        .faq-question { 
            cursor: pointer; 
            padding: 1rem; 
            font-weight: bold; 
        }
        .faq-answer { 
            display: none; 
            padding: 1rem; 
            border-top: 1px solid #e0e0e0; 
        }
    </style>
</head>
<body>
    <div class="container py-5">
        <h2 class="mb-4">Perguntas Frequentes</h2>
        <?php foreach ($faqs as $faq): ?>
            <div class="faq-card">
                <div class="faq-question d-flex justify-content-between align-items-center">
                    <span><?= htmlspecialchars($faq['question']) ?></span>
                    <span class="mdi mdi-plus mdi-24px"></span>
                </div>
                <div class="faq-answer" style="background-color: #DFDFDF;"> <?= nl2br(htmlspecialchars($faq['answer'])) ?> </div>
            </div>
        <?php endforeach; ?>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(function () {
            $('.faq-question').on('click', function () {
                $(this).next('.faq-answer').slideToggle(200);
            });
        });
    </script>
</body>
</html>
