import { useEffect, useState } from "react";
import { useNavigate, useParams } from "react-router-dom";
import { Button } from "@/components/ui/button";
import { Card, CardContent } from "@/components/ui/card";
import { Badge } from "@/components/ui/badge";
import { Dialog, DialogContent, DialogDescription, DialogFooter, DialogHeader, DialogTitle } from "@/components/ui/dialog";
import { RadioGroup, RadioGroupItem } from "@/components/ui/radio-group";
import { Label } from "@/components/ui/label";
import { useToast } from "@/hooks/use-toast";
import { Camera, LogOut, ShoppingCart, Check, Calendar } from "lucide-react";

interface Album {
  id: string;
  title: string;
  description: string;
  date: string;
  managerEmail: string;
  status: "draft" | "published";
}

interface Photo {
  id: string;
  albumId: string;
  dataUrl: string;
  uploadedAt: string;
}

type PriceOption = "digital" | "digital_print";

const PRICES = {
  digital: 5,
  digital_print: 15,
};

const ClientAlbum = () => {
  const { id } = useParams();
  const [album, setAlbum] = useState<Album | null>(null);
  const [photos, setPhotos] = useState<Photo[]>([]);
  const [selectedPhotos, setSelectedPhotos] = useState<Set<string>>(new Set());
  const [isCheckoutOpen, setIsCheckoutOpen] = useState(false);
  const [priceOption, setPriceOption] = useState<PriceOption>("digital");
  const navigate = useNavigate();
  const { toast } = useToast();

  useEffect(() => {
    const session = localStorage.getItem("client_session");
    if (!session) {
      navigate(`/client-auth?album=${id}`);
      return;
    }

    const { email } = JSON.parse(session);

    // Load album
    const savedAlbums = localStorage.getItem("albums");
    if (savedAlbums) {
      const albums = JSON.parse(savedAlbums);
      const currentAlbum = albums.find(
        (a: Album) => a.id === id && a.managerEmail === email && a.status === "published"
      );
      
      if (currentAlbum) {
        setAlbum(currentAlbum);
      } else {
        toast({
          title: "Álbum não encontrado",
          description: "Não tem acesso a este álbum.",
          variant: "destructive",
        });
        navigate("/client-auth");
        return;
      }
    }

    // Load photos
    const savedPhotos = localStorage.getItem(`photos_${id}`);
    if (savedPhotos) {
      setPhotos(JSON.parse(savedPhotos));
    }
  }, [id, navigate, toast]);

  const handleLogout = () => {
    localStorage.removeItem("client_session");
    toast({
      title: "Sessão terminada",
      description: "Até breve!",
    });
    navigate("/client-auth");
  };

  const togglePhotoSelection = (photoId: string) => {
    const newSelection = new Set(selectedPhotos);
    if (newSelection.has(photoId)) {
      newSelection.delete(photoId);
    } else {
      newSelection.add(photoId);
    }
    setSelectedPhotos(newSelection);
  };

  const calculateTotal = () => {
    return selectedPhotos.size * PRICES[priceOption];
  };

  const handleCheckout = () => {
    if (selectedPhotos.size === 0) {
      toast({
        title: "Nenhuma foto selecionada",
        description: "Selecione pelo menos uma foto para comprar.",
        variant: "destructive",
      });
      return;
    }
    setIsCheckoutOpen(true);
  };

  const handlePurchase = () => {
    toast({
      title: "Compra realizada!",
      description: `${selectedPhotos.size} ${selectedPhotos.size === 1 ? 'foto' : 'fotos'} - Total: €${calculateTotal()}`,
    });
    setSelectedPhotos(new Set());
    setIsCheckoutOpen(false);
  };

  if (!album) {
    return (
      <div className="min-h-screen flex items-center justify-center">
        <p className="text-muted-foreground">A carregar...</p>
      </div>
    );
  }

  return (
    <div className="min-h-screen bg-gradient-to-br from-background via-secondary/20 to-background">
      <header className="border-b border-border/50 bg-card/50 backdrop-blur-sm sticky top-0 z-10">
        <div className="container mx-auto px-4 py-4">
          <div className="flex items-center justify-between">
            <div className="flex items-center gap-3">
              <div className="w-10 h-10 rounded-xl bg-gradient-to-br from-primary to-accent flex items-center justify-center">
                <Camera className="w-5 h-5 text-primary-foreground" />
              </div>
              <div>
                <h1 className="text-xl font-bold">{album.title}</h1>
                <p className="text-sm text-muted-foreground flex items-center gap-2">
                  <Calendar className="w-4 h-4" />
                  {new Date(album.date).toLocaleDateString('pt-PT')}
                </p>
              </div>
            </div>
            <div className="flex items-center gap-3">
              {selectedPhotos.size > 0 && (
                <Button onClick={handleCheckout} className="gap-2">
                  <ShoppingCart className="w-4 h-4" />
                  Comprar ({selectedPhotos.size})
                </Button>
              )}
              <Button variant="outline" onClick={handleLogout}>
                <LogOut className="w-4 h-4 mr-2" />
                Sair
              </Button>
            </div>
          </div>
        </div>
      </header>

      <main className="container mx-auto px-4 py-8">
        {album.description && (
          <Card className="mb-8 border-border/50">
            <CardContent className="pt-6">
              <p className="text-muted-foreground">{album.description}</p>
            </CardContent>
          </Card>
        )}

        {photos.length === 0 ? (
          <Card className="border-dashed">
            <CardContent className="flex flex-col items-center justify-center py-16">
              <Camera className="w-16 h-16 text-muted-foreground/50 mb-4" />
              <h3 className="text-xl font-semibold mb-2">Sem fotos disponíveis</h3>
              <p className="text-muted-foreground text-center">
                O fotógrafo ainda não adicionou fotos a este álbum.
              </p>
            </CardContent>
          </Card>
        ) : (
          <div className="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
            {photos.map((photo) => {
              const isSelected = selectedPhotos.has(photo.id);
              return (
                <Card
                  key={photo.id}
                  className={`group overflow-hidden border-2 cursor-pointer transition-all duration-300 ${
                    isSelected
                      ? "border-primary shadow-lg scale-[0.98]"
                      : "border-border/50 hover:border-primary/50 hover:shadow-md"
                  }`}
                  onClick={() => togglePhotoSelection(photo.id)}
                >
                  <div className="aspect-square relative">
                    <img
                      src={photo.dataUrl}
                      alt="Event photo"
                      className="w-full h-full object-cover"
                    />
                    {isSelected && (
                      <div className="absolute inset-0 bg-primary/20 flex items-center justify-center">
                        <div className="w-12 h-12 rounded-full bg-primary flex items-center justify-center">
                          <Check className="w-6 h-6 text-primary-foreground" />
                        </div>
                      </div>
                    )}
                  </div>
                </Card>
              );
            })}
          </div>
        )}
      </main>

      <Dialog open={isCheckoutOpen} onOpenChange={setIsCheckoutOpen}>
        <DialogContent>
          <DialogHeader>
            <DialogTitle>Finalizar Compra</DialogTitle>
            <DialogDescription>
              {selectedPhotos.size} {selectedPhotos.size === 1 ? 'foto selecionada' : 'fotos selecionadas'}
            </DialogDescription>
          </DialogHeader>
          <div className="space-y-6 py-4">
            <div className="space-y-4">
              <Label>Escolha o tipo de entrega</Label>
              <RadioGroup value={priceOption} onValueChange={(value) => setPriceOption(value as PriceOption)}>
                <div className="flex items-center space-x-3 border border-border/50 rounded-lg p-4 hover:border-primary/50 transition-colors">
                  <RadioGroupItem value="digital" id="digital" />
                  <Label htmlFor="digital" className="flex-1 cursor-pointer">
                    <div className="font-medium">Digital</div>
                    <div className="text-sm text-muted-foreground">Download em alta resolução</div>
                  </Label>
                  <Badge variant="secondary">€{PRICES.digital}/foto</Badge>
                </div>
                <div className="flex items-center space-x-3 border border-border/50 rounded-lg p-4 hover:border-primary/50 transition-colors">
                  <RadioGroupItem value="digital_print" id="digital_print" />
                  <Label htmlFor="digital_print" className="flex-1 cursor-pointer">
                    <div className="font-medium">Digital + Impressão</div>
                    <div className="text-sm text-muted-foreground">Download + envio de impressão física</div>
                  </Label>
                  <Badge variant="secondary">€{PRICES.digital_print}/foto</Badge>
                </div>
              </RadioGroup>
            </div>
            
            <div className="border-t pt-4">
              <div className="flex justify-between text-lg font-semibold">
                <span>Total:</span>
                <span>€{calculateTotal()}</span>
              </div>
            </div>
          </div>
          <DialogFooter>
            <Button variant="outline" onClick={() => setIsCheckoutOpen(false)}>
              Cancelar
            </Button>
            <Button onClick={handlePurchase}>
              Confirmar Compra
            </Button>
          </DialogFooter>
        </DialogContent>
      </Dialog>
    </div>
  );
};

export default ClientAlbum;
