<?php

abstract class Controller
{
    protected Request $request;
    protected PageView $view;

    public function __construct()
    {
        $this->request = new Request();
        $this->view = new PageView();
        
        $this->init();
    }

    protected function init(): void 
    {
    }

    public function redirect(string $route): void
    {
        if (!headers_sent()) {
            header('Location: index.php?route=' . ltrim($route, '/'));
            exit;
        }
        
        echo '<script>window.location.href="index.php?route=' . $route . '";</script>';
        exit;
    }

    protected function isAjax(): bool
    {
        return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && 
               $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest';
    }
}