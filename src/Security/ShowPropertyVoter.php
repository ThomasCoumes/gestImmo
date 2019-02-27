<?php
/**
 * Created by PhpStorm.
 * User: thocou
 * Date: 14/02/19
 * Time: 20:34
 */

namespace App\Security;

use App\Entity\Property;
use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\VoterInterface;

class ShowPropertyVoter implements VoterInterface
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
        if (!$subject instanceof Property) {
            return self::ACCESS_ABSTAIN;
        }

        if (!in_array('SHOW', $attributes)) {
            return self::ACCESS_ABSTAIN;
        }

        $user = $token->getUser();

        if (!$user instanceof User) {
            return self::ACCESS_DENIED;
        }

        $lessee = $subject->getLessees();

        if ($user->getEmail() !== $lessee->getValues()['email']) {
            return self::ACCESS_DENIED;
        }

        return self::ACCESS_GRANTED;
    }
}
