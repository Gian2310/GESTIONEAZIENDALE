import './bootstrap'; // Mantiene l'inizializzazione JS
import '../scss/app.scss'; // Importa il CSS (Bootstrap/Custom)

// Questo importa i componenti JavaScript interattivi di Bootstrap
import * as bootstrap from 'bootstrap';

// Rende Bootstrap accessibile globalmente (opzionale, ma utile)
window.bootstrap = bootstrap;

// Se stai usando Alpine.js con Breeze/Jetstream, assicurati che sia qui
import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();