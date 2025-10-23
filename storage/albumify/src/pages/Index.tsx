import { useEffect } from "react";
import { useNavigate } from "react-router-dom";
import { Button } from "@/components/ui/button";
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from "@/components/ui/card";
import { Camera, ShoppingBag, Upload } from "lucide-react";

const Index = () => {
  const navigate = useNavigate();

  useEffect(() => {
    const photographerSession = localStorage.getItem("photographer_session");
    if (photographerSession) {
      navigate("/dashboard");
    }
  }, [navigate]);

  return (
    <div className="min-h-screen bg-gradient-to-br from-background via-secondary/20 to-background">
      <header className="border-b border-border/50 bg-card/50 backdrop-blur-sm">
        <div className="container mx-auto px-4 py-4 flex items-center justify-between">
          <div className="flex items-center gap-3">
            <div className="w-10 h-10 rounded-xl bg-gradient-to-br from-primary to-accent flex items-center justify-center">
              <Camera className="w-5 h-5 text-primary-foreground" />
            </div>
            <h1 className="text-xl font-bold">PhotoEvents</h1>
          </div>
        </div>
      </header>

      <main className="container mx-auto px-4 py-16">
        <div className="max-w-4xl mx-auto text-center mb-16">
          <h2 className="text-4xl font-bold tracking-tight mb-4">
            Plataforma de Venda de Fotos de Eventos
          </h2>
          <p className="text-xl text-muted-foreground">
            Para fotógrafos e clientes partilharem e adquirirem fotografias de eventos
          </p>
        </div>

        <div className="grid md:grid-cols-2 gap-8 max-w-4xl mx-auto">
          <Card className="border-border/50 hover:shadow-lg transition-shadow">
            <CardHeader className="text-center">
              <div className="flex justify-center mb-4">
                <div className="w-16 h-16 rounded-2xl bg-gradient-to-br from-primary to-accent flex items-center justify-center">
                  <Upload className="w-8 h-8 text-primary-foreground" />
                </div>
              </div>
              <CardTitle className="text-2xl">Sou Fotógrafo</CardTitle>
              <CardDescription>
                Faça upload e gerir as suas fotos de eventos
              </CardDescription>
            </CardHeader>
            <CardContent>
              <Button onClick={() => navigate("/auth")} className="w-full" size="lg">
                Aceder como Fotógrafo
              </Button>
            </CardContent>
          </Card>

          <Card className="border-border/50 hover:shadow-lg transition-shadow">
            <CardHeader className="text-center">
              <div className="flex justify-center mb-4">
                <div className="w-16 h-16 rounded-2xl bg-gradient-to-br from-primary to-accent flex items-center justify-center">
                  <ShoppingBag className="w-8 h-8 text-primary-foreground" />
                </div>
              </div>
              <CardTitle className="text-2xl">Sou Cliente</CardTitle>
              <CardDescription>
                Aceder ao álbum do meu evento e comprar fotos
              </CardDescription>
            </CardHeader>
            <CardContent>
              <Button onClick={() => navigate("/client-auth")} className="w-full" size="lg" variant="outline">
                Aceder ao Meu Álbum
              </Button>
            </CardContent>
          </Card>
        </div>
      </main>
    </div>
  );
};

export default Index;
