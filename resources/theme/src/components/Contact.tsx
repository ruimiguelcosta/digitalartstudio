import { Button } from "@/components/ui/button";
import { Mail, Phone } from "lucide-react";

const Contact = () => {
  return (
    <section id="contact" className="py-24 px-4">
      <div className="max-w-3xl mx-auto text-center">
        <h2 className="font-serif text-4xl md:text-5xl font-bold mb-6 text-foreground">
          Vamos Trabalhar Juntos
        </h2>
        <p className="text-lg text-muted-foreground mb-12 leading-relaxed">
          Entre em contacto para discutir o seu próximo projeto. 
          Será um prazer ajudar a preservar os seus momentos especiais.
        </p>
        <div className="flex flex-col sm:flex-row gap-4 justify-center items-center">
          <Button 
            size="lg"
            className="bg-primary text-primary-foreground hover:bg-primary/90 font-semibold px-8"
          >
            <Mail className="mr-2 h-5 w-5" />
            Enviar Email
          </Button>
          <Button 
            size="lg"
            variant="outline"
            className="border-border hover:bg-secondary font-semibold px-8"
          >
            <Phone className="mr-2 h-5 w-5" />
            Ligar Agora
          </Button>
        </div>
      </div>
    </section>
  );
};

export default Contact;
