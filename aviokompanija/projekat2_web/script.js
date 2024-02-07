var logo = document.getElementById('logo');

logo.addEventListener('mouseenter', function() {
  logo.style.transform = 'scale(1.2)';
});

logo.addEventListener('mouseleave', function() {
  logo.style.transform = 'scale(1)';
});
