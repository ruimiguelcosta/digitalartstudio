import { Camera } from "lucide-react";

const About = () => {
  return (
    <section className="py-24 px-4 bg-secondary">
      <div className="max-w-4xl mx-auto text-center">
        <div className="inline-flex items-center justify-center w-16 h-16 rounded-full bg-primary/10 mb-6">
          <Camera className="w-8 h-8 text-primary" />
        </div>
        <h2 className="font-serif text-4xl md:text-5xl font-bold mb-6 text-foreground">
          Sobre Mim
        </h2>
        <p className="text-lg md:text-xl text-muted-foreground leading-relaxed mb-6">
          Com mais de <span className="text-primary font-semibold">30 anos de experiência</span> em fotografia profissional, 
          dedico-me a capturar os momentos mais preciosos da sua vida com sensibilidade artística e técnica apurada.
        </p>
        <p className="text-lg text-muted-foreground leading-relaxed">
          Cada evento é único, e o meu objetivo é contar a sua história através de imagens autênticas 
          e emotivas que permanecerão para sempre.
        </p>
      </div>
    </section>
  );
};

export default About;
