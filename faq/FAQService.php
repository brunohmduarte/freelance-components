<?php

require_once './FAQRepository.php';

/**
 * Class
 */
class FAQService
{
    const ACTION_CREATE = 'create';
    const ACTION_EDIT   = 'edit';
    const ACTION_DELETE = 'delete';
    const ACTIONS = [
        self::ACTION_CREATE,
        self::ACTION_EDIT,
        self::ACTION_DELETE
    ];

    private FAQRepository $repository;

    /**
     * Constructor
     * 
     * @return void
     */
    public function __construct()
    {
        $this->repository = new FAQRepository();
    }

    /**
     * Return all questions
     * 
     * @return array
     */
    public function getAllFaqs(): array
    {
        return $this->repository->findAll();
    }

    /**
     * Return question by id
     * 
     * @return array
     */
    public function getFaqById(int $id): array
    {
        $return = $this->repository->findById($id);
        if (empty($return)) {
            return [];
        }

        return $return;
    }
    
    /**
     * Create a new question
     * 
     * @param string $question
     * @param string $answer
     * @param string $active
     * @return void
     */
    public function createFaq(string $question, string $answer, string $active): void
    {
        $this->repository->insert($question, $answer, $active);
    }

    /**
     * Update a question
     * 
     * @param mixed $params
     * @return bool
     */
    public function updateFaq($params): bool
    {
        $id       = $params['id'] ?? '';
        $question = $params['question'] ?? '';
        $answer   = $params['answer'] ?? '';
        $active   = $params['active'] ?? '';

        if (empty($id)) {
            return false;
        }
        
        $existsQuestion = $this->repository->findById($id);
        if (empty($existsQuestion)) {
            return false;
        }

        return $this->repository->update($id, $question, $answer, $active);
    }

    /**
     * Delete a question
     * 
     * @param int $id
     * @return void
     */
    public function deleteFaq(int $id): void
    {
        $this->repository->delete($id);
    }

    /**
     * Return all questions
     * 
     * @return array
     */
    public function listFaq() 
    {
        return $this->getAllFaqs();
    }
}
