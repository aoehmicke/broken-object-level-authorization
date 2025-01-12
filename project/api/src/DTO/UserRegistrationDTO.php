<?php

namespace App\DTO;

use ApiPlatform\Metadata\ApiProperty;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[UniqueEntity(
    fields: ['email'],
    message: 'The email "{{ value }}" is already used.',
    entityClass: User::class,
    groups: ['user:write']),
]
class UserRegistrationDTO
{
    #[Assert\Email]
    #[Assert\NotBlank]
    #[ApiProperty(description: 'The email of the user.', example: '<EMAIL>')]
    #[Groups(groups: ['user:write'])]
    public string $email = '';

    #[Assert\Length(min: 8, max: 32)]
    #[Assert\Type('string')]
    #[Assert\NotBlank]
    #[ApiProperty(example: 'Password')]
    #[Groups(groups: ['user:write'])]
    public string $password = '';
}