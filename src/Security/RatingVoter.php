<?php


namespace App\Security;


use App\Entity\Rating;
use App\Entity\User;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class RatingVoter extends Voter
{
    const DELETE = "delete";
    const EDIT = "edit";
    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    protected function supports(string $attribute, $subject)
    {
        // if the attribute isn't one we support, return false
        if (!in_array($attribute, [self::DELETE, self::EDIT])) {
            return false;
        }

        // only vote on Post objects inside this voter
        if (!$subject instanceof Rating) {
            return false;
        }

        return true;
    }


    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token)
    {
        $user = $token->getUser();

        if (!$user instanceof User) {
            // the user must be logged in; if not, deny access
            return false;
        }

        if ($this->security->isGranted('ROLE_ADMIN')) {
            return true;
        }

        /** @var Rating $rating */
        $rating = $subject;

        switch ($attribute) {
            case self::DELETE:
                return $this->canDelete($rating, $user);
            case self::EDIT:
                return $this->canEdit($rating, $user);
        }

        throw new \LogicException('This code should not be reached!');
    }

    private function canDelete(Rating $rating, User $user)
    {
        return $user === $rating->getUser();
    }

    private function canEdit(Rating $rating, User $user) {
        return $user === $rating->getUser();
    }

}