// Yara-Med1 - Main JavaScript

(function () {
  'use strict';

  // Mobile menu toggle
  var menuBtn = document.getElementById('mobile-menu-btn');
  var mobileMenu = document.getElementById('mobile-menu');

  if (menuBtn && mobileMenu) {
    menuBtn.addEventListener('click', function () {
      mobileMenu.classList.toggle('hidden');
    });

    // Close mobile menu when clicking a link
    var links = mobileMenu.querySelectorAll('a');
    for (var i = 0; i < links.length; i++) {
      links[i].addEventListener('click', function () {
        mobileMenu.classList.add('hidden');
      });
    }
  }

  // Contact form handling - opens mailto: with form data
  var contactForm = document.getElementById('contact-form');
  var formSuccess = document.getElementById('form-success');

  if (contactForm) {
    contactForm.addEventListener('submit', function (e) {
      e.preventDefault();

      var name = document.getElementById('name').value;
      var phone = document.getElementById('phone').value;
      var email = document.getElementById('email').value;
      var message = document.getElementById('message').value;

      // Build email body
      var subject = encodeURIComponent('Kontaktanfrage von ' + name);
      var body = encodeURIComponent(
        'Name: ' + name + '\n' +
        'Telefon: ' + phone + '\n' +
        'E-Mail: ' + (email || 'nicht angegeben') + '\n\n' +
        'Nachricht:\n' + message
      );

      // Open default email client
      // TODO: E-Mail-Adresse hier anpassen!
      window.location.href = 'mailto:info@yara-med1.de?subject=' + subject + '&body=' + body;

      // Show success message
      formSuccess.classList.remove('hidden');

      // Hide success message after 5 seconds
      setTimeout(function () {
        formSuccess.classList.add('hidden');
      }, 5000);
    });
  }
})();
