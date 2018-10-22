<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\User;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;

/**
 * Defines the sample users to load in the database before running the unit and
 * functional tests. Execute this command to load the data.
 *
 *   $ php bin/console doctrine:fixtures:load
 *
 * See https://symfony.com/doc/current/bundles/DoctrineFixturesBundle/index.html
 *
 * @author Ryan Weaver <weaverryan@gmail.com>
 * @author Javier Eguiluz <javier.eguiluz@gmail.com>
 * @author Yonel Ceruto <yonelceruto@gmail.com>
 */
class UserFixtures extends AbstractFixture implements ContainerAwareInterface
{
    use ContainerAwareTrait;

    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $manager)
    {
        $passwordEncoder = $this->container->get('security.password_encoder');

        $admin = new User();
        $admin->setFullName('Admin');
        $admin->setUsername('admin');
        $admin->setEmail('admin@gmail.com');
        $admin->setRoles(['ROLE_ADMIN']);
        $admin->setStatus(1);
        $encodedPassword = $passwordEncoder->encodePassword($admin, 'kitten');
        $admin->setPassword($encodedPassword);
        $manager->persist($admin);
        // In case if fixture objects have relations to other fixtures, adds a reference
        // to that object by name and later reference it to form a relation.
        // See https://symfony.com/doc/current/bundles/DoctrineFixturesBundle/index.html#sharing-objects-between-fixtures
        $this->addReference('admin', $admin);

        $tomAdmin = new User();
        $tomAdmin->setFullName('Tom Doe');
        $tomAdmin->setUsername('tom_admin');
        $tomAdmin->setEmail('tom_admin@symfony.com');
        $tomAdmin->setRoles([]);
        $tomAdmin->setStatus(1);
        $encodedPassword = $passwordEncoder->encodePassword($tomAdmin, 'kitten');
        $tomAdmin->setPassword($encodedPassword);
        $manager->persist($tomAdmin);
        $this->addReference('tom-admin', $tomAdmin);

        $johnUser = new User();
        $johnUser->setFullName('John Doe');
        $johnUser->setUsername('john_user');
        $johnUser->setEmail('john_user@symfony.com');
        $johnUser->setStatus(1);
        $encodedPassword = $passwordEncoder->encodePassword($johnUser, 'kitten');
        $johnUser->setPassword($encodedPassword);
        $manager->persist($johnUser);
        $this->addReference('john-user', $johnUser);

        $manager->flush();
    }
}
