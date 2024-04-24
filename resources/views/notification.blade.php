<?php
    $url = explode("/", $_SERVER['REQUEST_URI']);
    $slug = $url[2];
?>

<x-app-layout>
    <livewire:sidebar />
    <livewire:notification :slug="$slug" />
</x-app-layout>

