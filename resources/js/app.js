import './bootstrap';
import Alpine from 'alpinejs'

window.Alpine = Alpine

document.addEventListener('alpine:init', () => {
    Alpine.store('ui', {
        sidebarOpen: false,
        dark: localStorage.theme === 'dark',

        toggleSidebar() {
            this.sidebarOpen = !this.sidebarOpen
        },

        closeSidebar() {
            this.sidebarOpen = false
        },

        toggleDark() {
            this.dark = !this.dark
            localStorage.theme = this.dark ? 'dark' : 'light'
            document.documentElement.classList.toggle('dark', this.dark)
        },

        init() {
            document.documentElement.classList.toggle('dark', this.dark)
        }
    })
})

Alpine.start()


