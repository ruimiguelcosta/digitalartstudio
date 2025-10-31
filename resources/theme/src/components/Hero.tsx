import { Button } from "@/components/ui/button";
import { ArrowRight } from "lucide-react";
import heroImage from "@/assets/hero-photography.jpg";

const Hero = () => {
  const scrollToContact = () => {
    const contactSection = document.getElementById('contact');
    contactSection?.scrollIntoView({ behavior: 'smooth' });
  };

  return (
    <section className="relative h-screen flex items-center justify-center overflow-hidden">
      <div 
        className="absolute inset-0 bg-cover bg-center"
        style={{ 
          backgroundImage: `url(${heroImage})`,
          filter: 'brightness(0.4)'
        }}
      />
      <div className="relative z-10 text-center px-4 max-w-4xl mx-auto animate-fade-in">
        <h1 className="font-serif text-5xl md:text-7xl font-bold mb-6 text-foreground">
          António Braga
        </h1>
        <p className="text-xl md:text-2xl mb-8 text-muted-foreground font-light">
          Capturando momentos inesquecíveis há mais de 30 anos
        </p>
        <Button 
          size="lg" 
          onClick={scrollToContact}
          className="bg-primary text-primary-foreground hover:bg-primary/90 font-semibold px-8 py-6 text-lg group"
        >
          Entre em Contacto
          <ArrowRight className="ml-2 group-hover:translate-x-1 transition-transform" />
        </Button>
      </div>
      <div className="absolute bottom-0 left-0 right-0 h-32 bg-gradient-to-t from-background to-transparent" />
    </section>
  );
};

export default Hero;
