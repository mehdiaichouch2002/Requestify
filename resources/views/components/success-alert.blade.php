@props(['value'])
<div class="bg-my-light-green text-my-green border border-green-400 text-green-700 mt-5 mb-3 px-4 py-3 rounded relative"
         role="alert">
        <span class="block sm:inline">{{$value}}</span>
        <span class="absolute  top-0 bottom-0 right-0 px-4 py-3 close-button">
    <svg class="fill-current h-6 w-6 text-green-500" role="button" xmlns="http://www.w3.org/2000/svg"
         viewBox="0 0 20 20">
    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
         class="w-6 h-6 text-my-green">
  <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
</svg>
    </svg>
  </span>
    </div>
<script>
    const closeButton = document.querySelector('.close-button');
    const alert = document.querySelector('.bg-my-light-green');

    closeButton.addEventListener('click', () => {
        alert.classList.add('hidden');
    });
</script>

