<?php
/*
 * Plugin Name: Playground Plugin
 * Description: Wtyczka do ćwiczenia. Aktualna zawartość: zadanie z TopTal - widget z 11 losowymi postami, widget z n losowymi postami, gdzie "n" to dowolna, podana przez uytkownika liczba, widget taki sam jak poprzedni + z mozliwością dodania grafiki do widgetu
 * Version: 1.5.1
 * Author: Adrian Szlegel
 */

// require_once(dirname(__FILE__).'/sidebars/sidebar-playground.php');

// WIDGET DISPLAYING 11 RANDOM POSTS
require_once(dirname(__FILE__).'/widgets/random-posts.php');

// WIDGET DISPLAYING SPECYFIED NUMBER OF RANDOM POSTS
require_once(dirname(__FILE__).'/widgets/random-posts-specify.php');

// WIDGET DISPLAYING SPECYFIED NUMBER OF RANDOM POSTS WITH WIDGET'S THUMBNAIL
require_once(dirname(__FILE__).'/widgets/random-posts-specify-with-thumbnail.php');