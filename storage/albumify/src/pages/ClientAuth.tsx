import { useState } from "react";
import { useNavigate, useSearchParams } from "react-router-dom";
import { Button } from "@/components/ui/button";
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from "@/components/ui/card";
import { Input } from "@/components/ui/input";
import { Label } from "@/components/ui/label";
import { useToast } from "@/hooks/use-toast";
import { Camera, ShoppingBag } from "lucide-react";

const ClientAuth = () => {
  const [email, setEmail] = useState("");
  const [isLoading, setIsLoading] = useState(false);
  const navigate = useNavigate();
  const [searchParams] = useSearchParams();
  const { toast } = useToast();

  const handleLogin = async (e: React.FormEvent) => {
    e.preventDefault();
    setIsLoading(true);

    // Simulate authentication
    setTimeout(() => {
      // Find albums where this email is the manager
      const savedAlbums = localStorage.getItem("albums");
      if (savedAlbums) {
        const albums = JSON.parse(savedAlbums);
        const clientAlbums = albums.filter(
          (album: any) => album.managerEmail === email && album.status === "published"
        );

        if (clientAlbums.length > 0) {
          localStorage.setItem("client_session", JSON.stringify({ email }));
          toast({
            title: "Bem-vindo!",
            description: "Acesso autorizado aos seus álbuns.",
          });
          
          // Redirect to first album or specified album
          const albumId = searchParams.get("album") || clientAlbums[0].id;
          navigate(`/client-album/${albumId}`);
        } else {
          toast({
            title: "Acesso negado",
            description: "Não foram encontrados álbuns para este email.",
            variant: "destructive",
          });
        }
      }
      setIsLoading(false);
    }, 800);
  };

  return (
    <div className="min-h-screen bg-gradient-to-br from-background via-secondary/20 to-background flex items-center justify-center p-4">
      <Card className="w-full max-w-md border-border/50">
        <CardHeader className="space-y-4 text-center">
          <div className="flex justify-center">
            <div className="w-16 h-16 rounded-2xl bg-gradient-to-br from-primary to-accent flex items-center justify-center">
              <ShoppingBag className="w-8 h-8 text-primary-foreground" />
            </div>
          </div>
          <div>
            <CardTitle className="text-2xl">Acesso ao Álbum</CardTitle>
            <CardDescription className="mt-2">
              Introduza o seu email para aceder às fotos do evento
            </CardDescription>
          </div>
        </CardHeader>
        <CardContent>
          <form onSubmit={handleLogin} className="space-y-4">
            <div className="space-y-2">
              <Label htmlFor="email">Email</Label>
              <Input
                id="email"
                type="email"
                placeholder="seu@email.com"
                value={email}
                onChange={(e) => setEmail(e.target.value)}
                required
              />
            </div>
            <Button type="submit" className="w-full" disabled={isLoading}>
              {isLoading ? "A validar..." : "Aceder ao Álbum"}
            </Button>
          </form>
        </CardContent>
      </Card>
    </div>
  );
};

export default ClientAuth;
