<?php

class DoctorsController extends PageController
{
    public function action_list(): void
    {
        $doctors = [
            [
                'name' => 'Олександр Петренко',
                'specialty' => 'Хірург',
                'experience' => '15 років',
                'description' => 'Спеціаліст з хірургічних операцій та травматології'
            ],
            [
                'name' => 'Марія Іваненко',
                'specialty' => 'Терапевт',
                'experience' => '12 років',
                'description' => 'Догляд за внутрішніми захворюваннями та профілактика'
            ],
            [
                'name' => 'Андрій Коваленко',
                'specialty' => 'Кардіолог',
                'experience' => '10 років',
                'description' => 'Діагностика та лікування серцево-судинних захворювань'
            ],
            [
                'name' => 'Олена Сидоренко',
                'specialty' => 'Дерматолог',
                'experience' => '8 років',
                'description' => 'Лікування шкірних захворювань та алергій'
            ]
        ];

        $this->render('doctors/list', [
            'doctors' => $doctors
        ], 'Наші лікарі — Ветклініка «Лапки»');
    }
}