<?php

namespace App\State;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\DTO\UserRegistrationDTO;
use App\Entity\User;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

readonly class UserRegistrationProcessor implements ProcessorInterface
{
    public function __construct(
        #[Autowire(service: 'api_platform.doctrine.orm.state.persist_processor')]
        private ProcessorInterface $persistenceProcessor,
        private UserPasswordHasherInterface $passwordHasher
    )
    {

    }

    public function __invoke(mixed $data, Operation $operation, array $uriVariables = [], array $context = [])
    {
        return $this->process($data, $operation, $uriVariables, $context);
    }

    /**
     * @inheritDoc
     */
    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): ?User
    {
        if ($data instanceof UserRegistrationDTO) {
            $user = new User();

            $hashedPassword = $this->passwordHasher->hashPassword($user, $data->password);

            $user->setEmail($data->email);
            $user->setPassword($hashedPassword);
            $user->setRoles(['ROLE_USER']);

            $result = $this->persistenceProcessor->process($user, $operation, $uriVariables, $context);

            return $result;
        }

        throw new UnprocessableEntityHttpException(message: 'Invalid data');
    }
}