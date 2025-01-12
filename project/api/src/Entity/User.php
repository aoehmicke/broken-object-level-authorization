<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use App\Controller\RegistrationController;
use App\DTO\UserRegistrationDTO;
use App\State\UserRegistrationProcessor;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use SensitiveParameter;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity]
#[ORM\Table(name: 'users')]
#[ApiResource(
    operations: [
        new GetCollection(),
        new Post(
            uriTemplate: '/users/register',
            input: UserRegistrationDTO::class,
            output: User::class,
            name: 'user_post_register',
            processor: UserRegistrationProcessor::class,
        )
    ],
    routePrefix: '/api',
    normalizationContext: ['groups' => ['user:read']],
    denormalizationContext: ['groups' => ['user:write']],
    mercure: true
)]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'SEQUENCE')]
    #[ORM\Column(type: Types::INTEGER)]
    #[ApiProperty(
        description: 'The unique identifier of the user.',
        example: 1,
    )]
    private ?int $id = null;

    #[ApiProperty(
        description: 'The email of the user.',
        example: '<EMAIL>',
    )]
    #[Assert\Email]
    #[Assert\NotBlank(allowNull: false)]
    #[Groups(['user:write', 'user:read'])]
    #[ORM\Column(type: Types::STRING, length: 180, unique: true)]
    private string $email = '';

    #[ORM\Column(type: Types::STRING, length: 255)]
    #[Assert\NotBlank(allowNull: false)]
    #[Assert\Length(min: 8)]
    #[Assert\Length(max: 255)]
    #[Assert\Type('string')]
    #[Groups(['user:write'])]
    #[ApiProperty(example: 'Password')]
    private string $password = '';

    #[ORM\Column(type: 'json')]
    #[Assert\NotBlank(allowNull: false)]
    #[Assert\Type('array')]
    #[Groups(['user:read'])]
    #[ApiProperty(example: ['ROLE_USER'])]
    private array $roles = [];

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(#[SensitiveParameter] string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getUserIdentifier(): string
    {
        return $this->email;
    }
    public function getPassword(): ?string
    {
       return $this->password;
    }

    public function setPassword(#[SensitiveParameter] string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function eraseCredentials(): void
    {
        $this->password = '';
    }

    public function getRoles(): array
    {
        $roles = $this->roles;

        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = array_unique($roles);

        return $this;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }
}