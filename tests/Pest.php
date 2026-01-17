<?php

// Configuración única para Feature Tests
uses(
    Tests\TestCase::class, 
    Illuminate\Foundation\Testing\RefreshDatabase::class
)->in('Feature');

// Configuración opcional para Unit Tests
uses()->in('Unit');