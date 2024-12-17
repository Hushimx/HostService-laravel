    {{-- js scripts --}}
    <script src="{{ asset('front/js/jquery-3.7.0.min.js') }}"></script>
    <script src="{{ asset('front/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('front/js/all.min.js') }}" defer></script>
    <script src="{{ asset('front/js/aos.js') }}" sync></script>
    <script src="{{ asset('front/js/custom.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <script>
      AOS.init();

      // init tooltips
      const tooltips = document.querySelectorAll('.tt');
      tooltips.forEach(t => { new bootstrap.Tooltip(t) })
    </script>
    @livewireScripts
    @yield('scripts')
  </body>
</html>
