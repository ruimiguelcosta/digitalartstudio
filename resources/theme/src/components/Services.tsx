import { Card } from "@/components/ui/card";
import { Heart, Music, Theater, PartyPopper } from "lucide-react";

const services = [
  {
    icon: Heart,
    title: "Casamentos",
    description: "Capture cada emoção do seu dia especial com elegância e profissionalismo"
  },
  {
    icon: PartyPopper,
    title: "Festas",
    description: "Registo dos melhores momentos das suas celebrações e eventos sociais"
  },
  {
    icon: Music,
    title: "Peças Musicais",
    description: "Fotografia especializada para concertos e performances musicais"
  },
  {
    icon: Theater,
    title: "Teatro e Dança",
    description: "Captura profissional de espetáculos de teatro e apresentações de dança"
  }
];

const Services = () => {
  return (
    <section className="py-24 px-4">
      <div className="max-w-6xl mx-auto">
        <h2 className="font-serif text-4xl md:text-5xl font-bold text-center mb-16 text-foreground">
          Serviços
        </h2>
        <div className="grid grid-cols-1 md:grid-cols-2 gap-8">
          {services.map((service) => (
            <Card 
              key={service.title}
              className="p-8 bg-card border-border hover:border-primary transition-all duration-300 group cursor-pointer"
            >
              <div className="inline-flex items-center justify-center w-14 h-14 rounded-full bg-primary/10 mb-6 group-hover:bg-primary/20 transition-colors">
                <service.icon className="w-7 h-7 text-primary" />
              </div>
              <h3 className="font-serif text-2xl font-semibold mb-3 text-foreground">
                {service.title}
              </h3>
              <p className="text-muted-foreground leading-relaxed">
                {service.description}
              </p>
            </Card>
          ))}
        </div>
      </div>
    </section>
  );
};

export default Services;
