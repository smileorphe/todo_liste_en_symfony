<?php

namespace App\Security\Voter;

use App\Entity\Task;
use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

class TaskVoter extends Voter
{
    public const VIEW = 'view';
    public const EDIT = 'edit';
    public const DELETE = 'delete';

    protected function supports(string $attribute, mixed $subject): bool
    {
        // Si l'attribut n'est pas l'un de ceux que nous gérons, retourner false
        if (!in_array($attribute, [self::VIEW, self::EDIT, self::DELETE])) {
            return false;
        }

        // Seules les instances de Task sont supportées
        if (!$subject instanceof Task) {
            return false;
        }

        return true;
    }

    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();

        // L'utilisateur doit être connecté
        if (!$user instanceof UserInterface) {
            return false;
        }

        // Vous pouvez changer cette ligne si vous voulez vérifier un type spécifique d'utilisateur
        if (!$user instanceof User) {
            return false;
        }

        /** @var Task $task */
        $task = $subject;

        // Vérifier si l'utilisateur est le propriétaire de la tâche
        if ($task->getUser() !== $user) {
            return false;
        }

        // L'utilisateur est le propriétaire, donc il peut voir, modifier et supprimer sa tâche
        return true;
    }
}
