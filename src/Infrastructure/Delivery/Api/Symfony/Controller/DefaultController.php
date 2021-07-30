<?php


namespace App\Infrastructure\Delivery\Api\Symfony\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DefaultController extends AbstractController
{
    public function index()
    {
        return $this->json('Hello');
    }
}