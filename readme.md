# Limelight Cinemas Dynamic PHP Website

This website was created as a part of my HND Web Development course. I was tasked with designing, prototyping and developing a professional cinema website for an imaginary cinema chain. I created all of the initial documentation, including the requirements specification, design specification, user analysis, wireframing, style guides and more. I build the website from scratch without using any frameworks; my goal was to build my own mini CSS framework in the process of creating the site. I learned how to use SASS for the first time and used it to build a more organised and structured css folder layout with a more object/component-oriented approach to styling. This is also the first PHP-heavy project I have completed.

## Features

* A complete login / registration / logout system, capturing username, password, date of birth (used to calculate user age) and optional email address.
* Activities page with embedded film trivia quiz (accessible only to junior users under 18)
* A database of films, including title, age rating, genre, film poster image, stock, trailer link.
* Films with an age rating of 18 are kept hidden from junior/unregistered users.
* A simple booking system (restricted to users over 18) where a quantity of tickets for a specific film can be chosen, and the stock for that film will be updated accordingly.
* Page security checks on every page (except index, about and contact) ensuring that pages can't be accessed via the URL unless the user is logged in / over 18 / visiting from the correct previous page.
* A complete admin panel for admin users, where new users (regular and admin), films and stock can be added, updated or removed from the system.
* All user-facing pages are fully mobile responsive. Admin pages are responsive for computers and tablets only; mobile phones are outside of the intended usage environment for admins.
* Changes to the styling of the website for junior users, including junior-friendly images on the homepage image slider, larger body text and navigation link text, and a unique gradient background.