<x-layout.app title="Elite Security Services">

    <x-ui.navbar />

    {{-- <x-ui.hero-slider /> --}}

    <x-sections.about_us.officers />
    
    <x-sections.about_us.team-carousel />
    <x-sections.about_us.risk-assessment />
    <x-ui.footer />

    @push('scripts')
<script>
document.addEventListener('alpine:init', () => {

    Alpine.data('teamCarousel', () => ({
    index: 0,
    interval: null,
    total: 4,

    start() {
        this.interval = setInterval(() => {
            this.next()
        }, 5000)
    },

    next() {
        this.index = (this.index + 1) % this.total
    },

    prev() {
        this.index = this.index === 0 ? this.total - 1 : this.index - 1
    }
}))


})
</script>
  @endpush
</x-layout.app>
