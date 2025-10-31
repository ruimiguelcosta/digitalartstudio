<footer class="py-8 px-4 border-t border-border bg-secondary">
    <div class="max-w-6xl mx-auto text-center">
        <p class="text-muted-foreground mb-4">
            © {{ date('Y') }} António Braga. Todos os direitos reservados.
        </p>
        <p class="text-muted-foreground text-sm">
            Designed by <a href="https://skywingsdigital.com" target="_blank" rel="noopener noreferrer" class="text-primary hover:text-primary/90 underline underline-offset-4">Sky wings Digital</a>
        </p>
        @guest
            <div class="mt-4">
                <a 
                    href="{{ route('login') }}"
                    class="inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 border border-input bg-background hover:bg-accent hover:text-accent-foreground px-4 py-2"
                >
                    Login
                </a>
            </div>
        @endguest
    </div>
</footer>

