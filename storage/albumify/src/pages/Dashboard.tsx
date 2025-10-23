import { useEffect, useState } from "react";
import { useNavigate } from "react-router-dom";
import { Button } from "@/components/ui/button";
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from "@/components/ui/card";
import { Dialog, DialogContent, DialogDescription, DialogFooter, DialogHeader, DialogTitle, DialogTrigger } from "@/components/ui/dialog";
import { Input } from "@/components/ui/input";
import { Label } from "@/components/ui/label";
import { Textarea } from "@/components/ui/textarea";
import { useToast } from "@/hooks/use-toast";
import { Camera, LogOut, Plus, Image as ImageIcon, Calendar, User } from "lucide-react";
import { Badge } from "@/components/ui/badge";
import { z } from "zod";

const albumSchema = z.object({
  title: z.string().trim().min(1, "Título é obrigatório").max(100, "Título muito longo"),
  description: z.string().trim().max(500, "Descrição muito longa"),
  date: z.string().min(1, "Data é obrigatória"),
  managerEmail: z.string().trim().email("Email inválido").max(255, "Email muito longo"),
});

interface Album {
  id: string;
  title: string;
  description: string;
  date: string;
  managerEmail: string;
  coverImage?: string;
  photoCount: number;
  status: "draft" | "published";
}

const Dashboard = () => {
  const [albums, setAlbums] = useState<Album[]>([]);
  const [isCreateDialogOpen, setIsCreateDialogOpen] = useState(false);
  const [errors, setErrors] = useState<Record<string, string>>({});
  const navigate = useNavigate();
  const { toast } = useToast();

  useEffect(() => {
    const session = localStorage.getItem("photographer_session");
    if (!session) {
      navigate("/auth");
      return;
    }

    // Load albums from localStorage
    const savedAlbums = localStorage.getItem("albums");
    if (savedAlbums) {
      setAlbums(JSON.parse(savedAlbums));
    }
  }, [navigate]);

  const handleLogout = () => {
    localStorage.removeItem("photographer_session");
    toast({
      title: "Sessão terminada",
      description: "Até breve!",
    });
    navigate("/auth");
  };

  const handleCreateAlbum = (e: React.FormEvent<HTMLFormElement>) => {
    e.preventDefault();
    setErrors({});
    
    const formData = new FormData(e.currentTarget);
    const albumData = {
      title: formData.get("title") as string,
      description: formData.get("description") as string,
      date: formData.get("date") as string,
      managerEmail: formData.get("managerEmail") as string,
    };

    // Validate form data
    const result = albumSchema.safeParse(albumData);
    
    if (!result.success) {
      const fieldErrors: Record<string, string> = {};
      result.error.issues.forEach((issue) => {
        if (issue.path[0]) {
          fieldErrors[issue.path[0] as string] = issue.message;
        }
      });
      setErrors(fieldErrors);
      return;
    }
    
    const newAlbum: Album = {
      id: Date.now().toString(),
      ...result.data,
      photoCount: 0,
      status: "draft",
    };

    const updatedAlbums = [...albums, newAlbum];
    setAlbums(updatedAlbums);
    localStorage.setItem("albums", JSON.stringify(updatedAlbums));
    
    toast({
      title: "Álbum criado!",
      description: `${newAlbum.title} foi criado com sucesso.`,
    });
    
    setIsCreateDialogOpen(false);
    navigate(`/album/${newAlbum.id}`);
  };

  return (
    <div className="min-h-screen bg-gradient-to-br from-background via-secondary/20 to-background">
      <header className="border-b border-border/50 bg-card/50 backdrop-blur-sm sticky top-0 z-10">
        <div className="container mx-auto px-4 py-4 flex items-center justify-between">
          <div className="flex items-center gap-3">
            <div className="w-10 h-10 rounded-xl bg-gradient-to-br from-primary to-accent flex items-center justify-center">
              <Camera className="w-5 h-5 text-primary-foreground" />
            </div>
            <div>
              <h1 className="text-xl font-bold">PhotoEvents</h1>
              <p className="text-sm text-muted-foreground">Dashboard do Fotógrafo</p>
            </div>
          </div>
          <Button variant="outline" onClick={handleLogout}>
            <LogOut className="w-4 h-4 mr-2" />
            Sair
          </Button>
        </div>
      </header>

      <main className="container mx-auto px-4 py-8">
        <div className="flex items-center justify-between mb-8">
          <div>
            <h2 className="text-3xl font-bold tracking-tight">Meus Álbuns</h2>
            <p className="text-muted-foreground mt-1">Gerir os seus eventos e fotos</p>
          </div>
          
          <Dialog open={isCreateDialogOpen} onOpenChange={setIsCreateDialogOpen}>
            <DialogTrigger asChild>
              <Button className="gap-2">
                <Plus className="w-4 h-4" />
                Novo Álbum
              </Button>
            </DialogTrigger>
            <DialogContent>
              <form onSubmit={handleCreateAlbum}>
                <DialogHeader>
                  <DialogTitle>Criar Novo Álbum</DialogTitle>
                  <DialogDescription>
                    Adicione os detalhes do evento para criar um novo álbum
                  </DialogDescription>
                </DialogHeader>
                <div className="grid gap-4 py-4">
                  <div className="space-y-2">
                    <Label htmlFor="title">Título do Evento</Label>
                    <Input
                      id="title"
                      name="title"
                      placeholder="Ex: Casamento João & Maria"
                      required
                    />
                    {errors.title && (
                      <p className="text-sm text-destructive">{errors.title}</p>
                    )}
                  </div>
                  <div className="space-y-2">
                    <Label htmlFor="date">Data do Evento</Label>
                    <Input
                      id="date"
                      name="date"
                      type="date"
                      required
                    />
                    {errors.date && (
                      <p className="text-sm text-destructive">{errors.date}</p>
                    )}
                  </div>
                  <div className="space-y-2">
                    <Label htmlFor="managerEmail">Email do Gestor do Álbum</Label>
                    <Input
                      id="managerEmail"
                      name="managerEmail"
                      type="email"
                      placeholder="gestor@exemplo.com"
                      required
                    />
                    {errors.managerEmail && (
                      <p className="text-sm text-destructive">{errors.managerEmail}</p>
                    )}
                  </div>
                  <div className="space-y-2">
                    <Label htmlFor="description">Descrição</Label>
                    <Textarea
                      id="description"
                      name="description"
                      placeholder="Adicione detalhes sobre o evento..."
                      rows={3}
                    />
                    {errors.description && (
                      <p className="text-sm text-destructive">{errors.description}</p>
                    )}
                  </div>
                </div>
                <DialogFooter>
                  <Button type="submit">Criar Álbum</Button>
                </DialogFooter>
              </form>
            </DialogContent>
          </Dialog>
        </div>

        {albums.length === 0 ? (
          <Card className="border-dashed">
            <CardContent className="flex flex-col items-center justify-center py-16">
              <ImageIcon className="w-16 h-16 text-muted-foreground/50 mb-4" />
              <h3 className="text-xl font-semibold mb-2">Nenhum álbum criado</h3>
              <p className="text-muted-foreground text-center mb-6 max-w-md">
                Comece por criar o seu primeiro álbum de evento para fazer upload de fotos
              </p>
              <Button onClick={() => setIsCreateDialogOpen(true)}>
                <Plus className="w-4 h-4 mr-2" />
                Criar Primeiro Álbum
              </Button>
            </CardContent>
          </Card>
        ) : (
          <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            {albums.map((album) => (
              <Card
                key={album.id}
                className="group hover:shadow-lg transition-all duration-300 cursor-pointer border-border/50 overflow-hidden"
                onClick={() => navigate(`/album/${album.id}`)}
              >
                <div className="aspect-video bg-gradient-to-br from-secondary to-muted flex items-center justify-center">
                  {album.coverImage ? (
                    <img
                      src={album.coverImage}
                      alt={album.title}
                      className="w-full h-full object-cover"
                    />
                  ) : (
                    <ImageIcon className="w-16 h-16 text-muted-foreground/30" />
                  )}
                </div>
                <CardHeader>
                  <div className="flex items-center justify-between mb-2">
                    <CardTitle className="group-hover:text-primary transition-colors">
                      {album.title}
                    </CardTitle>
                    <Badge variant={album.status === "published" ? "default" : "secondary"}>
                      {album.status === "published" ? "Publicado" : "Rascunho"}
                    </Badge>
                  </div>
                  <CardDescription className="flex items-center gap-2">
                    <Calendar className="w-4 h-4" />
                    {new Date(album.date).toLocaleDateString('pt-PT')}
                  </CardDescription>
                </CardHeader>
                <CardContent>
                  <p className="text-sm text-muted-foreground line-clamp-2 mb-3">
                    {album.description}
                  </p>
                  <div className="space-y-2">
                    <div className="flex items-center gap-2 text-sm">
                      <ImageIcon className="w-4 h-4" />
                      <span className="text-muted-foreground">
                        {album.photoCount} {album.photoCount === 1 ? 'foto' : 'fotos'}
                      </span>
                    </div>
                    <div className="flex items-center gap-2 text-sm">
                      <User className="w-4 h-4" />
                      <span className="text-muted-foreground truncate">
                        {album.managerEmail}
                      </span>
                    </div>
                  </div>
                </CardContent>
              </Card>
            ))}
          </div>
        )}
      </main>
    </div>
  );
};

export default Dashboard;
