# Autorisierung auf Objektebene Implementieren

```PHP
#[Route('/order/{id}', name: 'order_show')]
//Verwenden eines Voters
#[IsGranted('view', 'order')]
public function getOrder(Order $order, Security $security): JsonResponse 
{
    // ...
}
```

```PHP
class OrderVoter extends Symfony\Component\Security\Core\Authorization\Voter\Voter
{
    protected function supports(string $attribute, mixed $subject): bool
    {
        return $attribute === 'view' && ($subject instanceof Order);
    }

    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token): bool
    {
        return $this->isUserOrder($subject, $token->getUser())
    }
}
```