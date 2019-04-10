<?php
/**
 * Created by PhpStorm.
 * User: thocou
 * Date: 11/03/19
 * Time: 09:39
 */

namespace App\Security;

use App\Entity\RentRelease;
use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\VoterInterface;

/**
 * Class EditRentReleaseVoter
 * @package App\Security
 */
class EditRentReleaseVoter implements VoterInterface
{

    /**
     * Returns the vote for the given parameters.
     *
     * This method must return one of the following constants:
     * ACCESS_GRANTED, ACCESS_DENIED, or ACCESS_ABSTAIN.
     *
     * @param TokenInterface $token A TokenInterface instance
     * @param mixed $subject The subject to secure
     * @param array $attributes An array of attributes associated with the method being invoked
     *
     * @return int either ACCESS_GRANTED, ACCESS_ABSTAIN, or ACCESS_DENIED
     */
    public function vote(TokenInterface $token, $subject, array $attributes)
    {
        if (!$subject instanceof RentRelease) {
            return self::ACCESS_ABSTAIN;
        }

        if (!in_array('EDIT_RENT_RELEASE', $attributes)) {
            return self::ACCESS_ABSTAIN;
        }

        $user = $token->getUser();

        if (!$user instanceof User) {
            return self::ACCESS_DENIED;
        }

        if ($user !== $subject->getUserRentRelease()) {
            return self::ACCESS_DENIED;
        }

        return self::ACCESS_GRANTED;
    }
}
