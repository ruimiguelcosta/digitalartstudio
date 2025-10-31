import { useEffect, useState } from 'react';
import { useParams, useNavigate, Link } from 'react-router-dom';
import { useAuth } from '@/contexts/AuthContext';
import { useCart } from '@/contexts/CartContext';
import { dashboardAlbums } from '@/data/dashboardAlbums';
import { Button } from '@/components/ui/button';
import { ArrowLeft, ShoppingCart, Check } from 'lucide-react';
import { Badge } from '@/components/ui/badge';
import {
  Carousel,
  CarouselContent,
  CarouselItem,
  CarouselNext,
  CarouselPrevious,
} from '@/components/ui/carousel';
import { useToast } from '@/hooks/use-toast';

const DashboardAlbum = () => {
  const { id } = useParams();
  const navigate = useNavigate();
  const { isAuthenticated, userEmail } = useAuth();
  const { cart, addToCart, removeFromCart, isInCart } = useCart();
  const { toast } = useToast();
  const [currentIndex, setCurrentIndex] = useState(0);

  useEffect(() => {
    if (!isAuthenticated) {
      navigate('/shop');
    }
  }, [isAuthenticated, navigate]);

  const album = dashboardAlbums.find(a => a.id === id);

  if (!album || album.clientEmail !== userEmail) {
    return (
      <div className="min-h-screen bg-background flex items-center justify-center px-4">
        <div className="text-center">
          <h1 className="text-4xl font-serif font-bold mb-4 text-foreground">
            Álbum não encontrado
          </h1>
          <Link to="/dashboard">
            <Button variant="outline">
              <ArrowLeft className="mr-2 h-4 w-4" />
              Voltar ao Dashboard
            </Button>
          </Link>
        </div>
      </div>
    );
  }

  const handleTogglePhoto = (photoIndex: number) => {
    if (isInCart(album.id, photoIndex)) {
      removeFromCart(album.id, photoIndex);
      toast({
        title: 'Foto removida',
        description: 'Foto removida do carrinho.',
      });
    } else {
      addToCart({
        albumId: album.id,
        photoIndex,
        photoSrc: album.photos[photoIndex],
        price: 10,
      });
      toast({
        title: 'Foto adicionada',
        description: 'Foto adicionada ao carrinho.',
      });
    }
  };

  return (
    <div className="min-h-screen bg-background">
      <header className="border-b border-border">
        <div className="max-w-7xl mx-auto px-4 py-4 flex justify-between items-center">
          <Link to="/dashboard">
            <Button variant="ghost">
              <ArrowLeft className="mr-2 h-4 w-4" />
              Voltar
            </Button>
          </Link>
          <Link to="/checkout">
            <Button variant="outline" className="relative">
              <ShoppingCart className="h-4 w-4 mr-2" />
              Carrinho
              {cart.length > 0 && (
                <Badge className="ml-2">
                  {cart.length}
                </Badge>
              )}
            </Button>
          </Link>
        </div>
      </header>

      <div className="max-w-6xl mx-auto px-4 py-12">
        <h1 className="font-serif text-4xl md:text-5xl font-bold mb-4 text-foreground">
          {album.title}
        </h1>
        <p className="text-lg text-muted-foreground mb-8">
          {album.description}
        </p>
        <p className="text-sm text-muted-foreground mb-8">
          Preço por foto: €10,00
        </p>

        <Carousel className="w-full" setApi={(api) => {
          api?.on('select', () => {
            setCurrentIndex(api.selectedScrollSnap());
          });
        }}>
          <CarouselContent>
            {album.photos.map((photo, index) => (
              <CarouselItem key={index}>
                <div className="relative">
                  <div className="relative aspect-[16/10] overflow-hidden rounded-lg">
                    <img
                      src={photo}
                      alt={`Foto ${index + 1}`}
                      className="w-full h-full object-cover"
                    />
                  </div>
                  <div className="mt-4 flex justify-between items-center">
                    <span className="text-muted-foreground">
                      Foto {index + 1} de {album.photos.length}
                    </span>
                    <Button
                      onClick={() => handleTogglePhoto(index)}
                      variant={isInCart(album.id, index) ? "default" : "outline"}
                    >
                      {isInCart(album.id, index) ? (
                        <>
                          <Check className="mr-2 h-4 w-4" />
                          Selecionada
                        </>
                      ) : (
                        <>
                          <ShoppingCart className="mr-2 h-4 w-4" />
                          Selecionar
                        </>
                      )}
                    </Button>
                  </div>
                </div>
              </CarouselItem>
            ))}
          </CarouselContent>
          <CarouselPrevious className="left-4" />
          <CarouselNext className="right-4" />
        </Carousel>

        {cart.filter(item => item.albumId === album.id).length > 0 && (
          <div className="mt-8 p-4 bg-card border border-border rounded-lg">
            <p className="text-foreground">
              {cart.filter(item => item.albumId === album.id).length} foto(s) selecionada(s) deste álbum
            </p>
          </div>
        )}
      </div>
    </div>
  );
};

export default DashboardAlbum;
