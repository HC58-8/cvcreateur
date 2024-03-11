// Variables pour suivant et précédent
var currentStep = 0;
var steps = document.querySelectorAll('.step');

function nextStep() {
    
    if (validateStep(currentStep)) {
        steps[currentStep].style.display = 'none';
        currentStep++;
        if (currentStep < steps.length) {
            steps[currentStep].style.display = 'block';
        }
    }
}

function prevStep() {
    if (currentStep > 0) {
        steps[currentStep].style.display = 'none';
        currentStep--;
        steps[currentStep].style.display = 'block';
    }
}

// Validation de l'étape
function validateStep(step) {
    var inputs = steps[step].querySelectorAll('input, select, textarea');
    var isValid = true;
    inputs.forEach(function(input) {
        if (!input.checkValidity()) {
            isValid = false;
        }
    });
    if (isValid) {
        return true;
    } else {
        steps[step].classList.add('was-validated');
        return false;
    }
}

// Écouteurs d'événements pour les boutons Suivant et Précédent
document.querySelectorAll('.next').forEach(function(button) {
    button.addEventListener('click', nextStep);
});

document.querySelectorAll('.prev').forEach(function(button) {
    button.addEventListener('click', prevStep);
});
