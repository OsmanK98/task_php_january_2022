<?php

namespace App\DataFixtures;

use App\Entity\Album;
use App\Entity\Band;
use App\Entity\Track;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class TestFixtures extends Fixture
{
    public function __construct(private UserPasswordHasherInterface $hasher)
    {
    }

    public function load(ObjectManager $manager): void
    {
        $user = new User();
        $user->setEmail('user@test.pl');
        $hashedPassword = $this->hasher->hashPassword($user, '12345678');
        $user->setPassword($hashedPassword);
        $manager->persist($user);

        $band1 = new Band('Happy Sad');
        $band2 = new Band('Freddie Mercury');
        $manager->persist($band1);
        $manager->persist($band2);

        $album1 = new Album('Wszystko jedno', 'image.png', 2005, true, $band1);
        $album2 = new Album('Nieprzygoda', 'image2.png', 2004, false, $band1);
        $album3 = new Album('The Freddie Mercury Album', 'image3.png', 1988, true, $band2);
        $manager->persist($album1);
        $manager->persist($album2);
        $manager->persist($album3);

        $track1 = new Track('Czysty jak łza', 'youtube.com', $album1);
        $track2 = new Track('Zanim pójdę', 'youtube.com', $album1);
        $track3 = new Track('Hymn 78', 'youtube.com', $album1);
        $track4 = new Track('Partyzant K', 'youtube.com', $album1);

        $track5 = new Track('Milowy las', 'youtube.com', $album2);
        $track6 = new Track('Styrana"', 'youtube.com', $album2);
        $track7 = new Track('Jałowiec', 'youtube.com', $album2);

        $track8 = new Track('Love Kills', 'youtube.com', $album3);
        $track9 = new Track('Your Kind Of Lover"', 'youtube.com', $album3);
        $track10 = new Track('Time', 'youtube.com', $album3);

        $manager->persist($track1);
        $manager->persist($track2);
        $manager->persist($track3);
        $manager->persist($track4);
        $manager->persist($track5);
        $manager->persist($track6);
        $manager->persist($track7);
        $manager->persist($track8);
        $manager->persist($track9);
        $manager->persist($track10);

        $manager->flush();
    }
}
