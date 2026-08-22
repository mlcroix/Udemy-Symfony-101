<?php

namespace App\Security\Voter;

use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Vote;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;
use App\Entity\MicroPost;
use App\Entity\User;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

final class MicroPostVoter extends Voter
{
    public const EDIT = 'POST_EDIT';
    public const VIEW = 'POST_VIEW';

    public function __construct(private AuthorizationCheckerInterface $security) {
    }

    protected function supports(string $attribute, mixed $subject): bool {
        return in_array($attribute, [MicroPost::EDIT, MicroPost::VIEW])
            && $subject instanceof \App\Entity\MicroPost;
    }

    /**
     * @param MicroPost $subject1
     */
    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token, ?Vote $vote = null): bool {
        /** @var User $user */
        $user = $token->getUser();

        if ($this->security->isGranted('ROLE_ADMIN')) {
            return true;
        }

        // if the user is anonymous, do not grant access
        if (!$user instanceof UserInterface) {
            $vote?->addReason('The user must be logged in to access this resource.');

            return false;
        }

        $isauthenticated = $user instanceof UserInterface;

        switch ($attribute) {
            case MicroPost::EDIT:
                return $isauthenticated && $subject->getAuthor()->getId() === $user->getId() || 
                $this->security->isGranted('ROLE_EDITOR');
                break;

            case MicroPost::VIEW:
                return true;
        }

        return false;
    }
}
