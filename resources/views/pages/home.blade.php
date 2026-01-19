<x-layout.app title="Elite Security Services">

    <x-ui.navbar />

    <x-ui.hero-slider />

    <x-ui.services-section />
    
    <x-sections.about />

    <x-sections.features />

    <x-sections.services />

<x-sections.testimonials />
<x-sections.concern />
{{-- <x-sections.contact_section /> --}}
<livewire:contact-form /> 
    <x-ui.footer />
    @push('scripts')
<script>
document.addEventListener('alpine:init', () => {

    Alpine.data('reveal', () => ({
        shown: false,
        show() {
            this.shown = true
        }
    }))

    Alpine.data('testimonialCarousel', () => ({
        index: 0,
        testimonials: [],
        interval: null,

        start() {
            this.interval = setInterval(() => {
                this.next()
            }, 6000) // cinematic timing
        },

        next() {
            this.index = (this.index + 1) % this.testimonials.length
        },

        prev() {
            this.index =
                this.index === 0
                    ? this.testimonials.length - 1
                    : this.index - 1
        }
    }))

})
</script>
  @endpush
</x-layout.app>
