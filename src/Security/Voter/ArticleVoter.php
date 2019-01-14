<?php

namespace App\Security\Voter;

use App\Entity\Article;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

class ArticleVoter extends Voter
{
    public const EDIT = 'EDIT';
    protected function supports($attribute, $subject)
    {
        return in_array($attribute, ['ARTICLE_EDIT'])
            && $subject instanceof Article;
    }

    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        $article = $subject;
        $user = $token->getUser();

        if (!$user instanceof UserInterface) {
            return false;
        }

        if (!$article instanceof Article) {
            return false;
        }

        switch ($attribute) {
            case 'ARTICLE_EDIT' :
                return  $article->getUser() === $user;
                break;

        }

        return false;
    }
}
