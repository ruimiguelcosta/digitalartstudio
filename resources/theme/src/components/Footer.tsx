const Footer = () => {
  return (
    <footer className="py-8 px-4 border-t border-border bg-secondary">
      <div className="max-w-6xl mx-auto text-center">
        <p className="text-muted-foreground">
          © {new Date().getFullYear()} António Braga. Todos os direitos reservados.
        </p>
      </div>
    </footer>
  );
};

export default Footer;
