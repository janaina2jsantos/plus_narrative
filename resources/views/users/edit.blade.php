<?php
    $url = explode("/", $_SERVER['REQUEST_URI']);
    $id = $url[2];
?>

<x-app-layout>
    <livewire:sidebar />
    <livewire:users :title="'Edit User'" :id="$id" />
</x-app-layout>