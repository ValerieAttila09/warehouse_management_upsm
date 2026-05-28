document.addEventListener('DOMContentLoaded', () => {
  const stepOne = document.getElementById('register-step-1');
  const stepTwo = document.getElementById('register-step-2');
  const continueBtn = document.getElementById('continue-btn');
  const backBtn = document.getElementById('back-btn');
  const submitBtn = stepTwo?.querySelector('button[type="submit"]');

  if (!stepOne || !stepTwo || !continueBtn || !backBtn || !submitBtn) {
    return;
  }

  const stepOneInputs = [
    document.getElementById('first_name'),
    document.getElementById('last_name'),
    document.getElementById('email'),
    document.getElementById('password'),
    document.getElementById('password_verify')
  ];

  const stepTwoInputs = [
    document.getElementById('country'),
    document.getElementById('phone'),
    document.getElementById('zip_code'),
    document.getElementById('address'),
    // document.getElementById('profile_photo')
  ];

  const setButtonState = (button, enabled) => {
    button.disabled = !enabled;
    button.classList.toggle('bg-black', enabled);
    button.classList.toggle('hover:bg-neutral-800', enabled);
    button.classList.toggle('shadow', enabled);
    button.classList.toggle('cursor-pointer', enabled);
    button.classList.toggle('bg-neutral-800/70', !enabled);
    button.classList.toggle('hover:bg-neutral-800/70', !enabled);
    button.classList.toggle('shadow-none', !enabled);
    button.classList.toggle('cursor-not-allowed', !enabled);
    button.classList.toggle('opacity-70', !enabled);
    button.setAttribute('aria-disabled', String(!enabled));
  };

  const validateStepOne = () => {
    const isValid = stepOneInputs.every((input) => input && input.value.trim().length > 0);
    setButtonState(continueBtn, isValid);
    return isValid;
  };

  const validateStepTwo = () => {
    const isValid = stepTwoInputs.every((input) => {
      if (!input) return false;

      if (input.type === 'file') {
        return input.files && input.files.length > 0;
      }

      return input.value.trim().length > 0;
    });

    setButtonState(submitBtn, isValid);
    return isValid;
  };

  gsap.set(stepTwo, {
    opacity: 0,
    x: 40,
    pointerEvents: 'none'
  });

  validateStepOne();
  validateStepTwo();

  stepOneInputs.forEach((input) => {
    input.addEventListener('input', validateStepOne);
  });

  stepTwoInputs.forEach((input) => {
    input.addEventListener('input', validateStepTwo);
    input.addEventListener('change', validateStepTwo);
  });

  continueBtn.addEventListener('click', () => {
    if (!validateStepOne()) {
      return;
    }

    const timeline = gsap.timeline({
      defaults: {
        duration: 0.45,
        ease: 'power2.inOut'
      }
    });

    timeline.to(stepOne, {
      x: -30,
      opacity: 0,
      pointerEvents: 'none'
    }).set(stepTwo, {
      pointerEvents: 'auto'
    }).to(stepTwo, {
      x: 0,
      opacity: 1
    }, '>-0.1');
  });

  backBtn.addEventListener('click', () => {
    const timeline = gsap.timeline({
      defaults: {
        duration: 0.4,
        ease: 'power2.inOut'
      }
    });

    timeline.to(stepTwo, {
      x: 40,
      opacity: 0,
      pointerEvents: 'none'
    }).set(stepOne, {
      pointerEvents: 'auto'
    }).to(stepOne, {
      x: 0,
      opacity: 1
    }, '>-0.1');
  });
});