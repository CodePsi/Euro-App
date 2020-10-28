<?php

return function (\Euro\DependencyInjection\Container\ServiceInjectionContainer $container) {
    $container->add(\Euro\Controller\QualificationController::class)->autowired();
};
