<?php

// This file has been auto-generated by the Symfony Dependency Injection Component for internal use.

if (\class_exists(\Container5ts0eks\appProdProjectContainer::class, false)) {
    // no-op
} elseif (!include __DIR__.'/Container5ts0eks/appProdProjectContainer.php') {
    touch(__DIR__.'/Container5ts0eks.legacy');

    return;
}

if (!\class_exists(appProdProjectContainer::class, false)) {
    \class_alias(\Container5ts0eks\appProdProjectContainer::class, appProdProjectContainer::class, false);
}

return new \Container5ts0eks\appProdProjectContainer(array(
    'container.build_hash' => '5ts0eks',
    'container.build_id' => '8a1eca60',
    'container.build_time' => 1534080828,
), __DIR__.\DIRECTORY_SEPARATOR.'Container5ts0eks');
