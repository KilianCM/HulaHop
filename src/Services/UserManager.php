<?php


namespace App\Services;


use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

class UserManager
{
    private $photonApi;
    private $entityManager;

    public function __construct(PhotonApi $photonApi, EntityManagerInterface $entityManager)
    {
        $this->photonApi = $photonApi;
        $this->entityManager = $entityManager;
    }

    public function addAddress(User $user, string $address, string $city, string $postalCode) {
        $user
            ->setAddress($address)
            ->setCity($city)
            ->setPostalCode($postalCode);
        $coordinates = $this->photonApi->transformAddressToCoordinate($address);
        $user->setLatitude($coordinates[1]);
        $user->setLongitude($coordinates[0]);
        $this->entityManager->persist($user);
        $this->entityManager->flush();
    }

}