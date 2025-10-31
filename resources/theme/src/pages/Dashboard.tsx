import { useEffect } from 'react';
import { useNavigate, Link } from 'react-router-dom';
import { useAuth } from '@/contexts/AuthContext';
import { useCart } from '@/contexts/CartContext';
import { dashboardAlbums } from '@/data/dashboardAlbums';
import { Button } from '@/components/ui/button';
import { LogOut, ShoppingCart } from 'lucide-react';
import { Badge } from '@/components/ui/badge';

const Dashboard = () => {
  const { isAuthenticated, userEmail, logout } = useAuth();
  const { cart } = useCart();
  const navigate = useNavigate();

  useEffect(() => {
    if (!isAuthenticated) {
      navigate('/shop');
    }
  }, [isAuthenticated, navigate]);

  const userAlbums = dashboardAlbums.filter(album => album.clientEmail === userEmail);

  const handleLogout = () => {
    logout();
    navigate('/shop');
  };

  if (!isAuthenticated) return null;

  return (
    <div className="min-h-screen bg-background">
      <header className="border-b border-border">
        <div className="max-w-7xl mx-auto px-4 py-4 flex justify-between items-center">
          <h1 className="font-serif text-2xl font-bold text-foreground">
            Os Meus Álbuns
          </h1>
          <div className="flex gap-3 items-center">
            <Link to="/checkout">
              <Button variant="outline" className="relative">
                <ShoppingCart className="h-4 w-4" />
                {cart.length > 0 && (
                  <Badge className="absolute -top-2 -right-2 h-5 w-5 flex items-center justify-center p-0">
                    {cart.length}
                  </Badge>
                )}
              </Button>
            </Link>
            <Button variant="ghost" onClick={handleLogout}>
              <LogOut className="h-4 w-4 mr-2" />
              Sair
            </Button>
          </div>
        </div>
      </header>

      <main className="max-w-7xl mx-auto px-4 py-12">
        {userAlbums.length === 0 ? (
          <div className="text-center py-12">
            <p className="text-muted-foreground text-lg">
              Não tem álbuns disponíveis no momento.
            </p>
          </div>
        ) : (
          <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            {userAlbums.map((album) => (
              <Link
                key={album.id}
                to={`/dashboard/album/${album.id}`}
                className="group"
              >
                <div className="relative aspect-[4/3] overflow-hidden rounded-lg mb-4">
                  <img
                    src={album.coverPhoto}
                    alt={album.title}
                    className="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110"
                  />
                  <div className="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                    <span className="text-white font-semibold">Ver Álbum</span>
                  </div>
                </div>
                <h3 className="font-serif text-xl font-bold text-foreground mb-2">
                  {album.title}
                </h3>
                <p className="text-muted-foreground">
                  {album.photos.length} fotografias
                </p>
              </Link>
            ))}
          </div>
        )}
      </main>
    </div>
  );
};

export default Dashboard;
