# Technisches Beispiel

Klassisches Controller Setup über Symfony:
```PHP
    #[Route('/order/{id}', name: 'order_show')]
    public function getOrder(Order $order): JsonResponse 
    {
        $order = $this->repositoy->getOrder($order);
        
        return $this->json($order);
    }
```