<?php


use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;

class OrderCreateService
{
    public function __construct(
        private readonly EventDispatcherInterface $eventDispatcher,
        private readonly AnaliticsService $analiticsService,
    ) {

    }
    public function create(OrderCreateDTO $orderCreateDTO): Order
    {
        /**
         * ......
         * some processes for creating an $order
         * .....
         */

        $this->eventDispatcher->dispatch(new MindBoxOrderCreateEvent($order));
        $this->eventDispatcher->dispatch(new OrderCreateNotificationEvent($order));

        if ($order->getPrice() > 500000) {
            $this->eventDispatcher->dispatch(new CallImportantClientEvent($order));
        }

        $this->analiticsService->addOrder($order);

        return $order;
    }
}