import { useEffect, useState } from 'react';
import { useNavigate, Link } from 'react-router-dom';
import { useAuth } from '@/contexts/AuthContext';
import { useCart } from '@/contexts/CartContext';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { ArrowLeft, Trash2 } from 'lucide-react';
import { useToast } from '@/hooks/use-toast';

const Checkout = () => {
  const { isAuthenticated, userEmail } = useAuth();
  const { cart, removeFromCart, clearCart, totalPrice } = useCart();
  const navigate = useNavigate();
  const { toast } = useToast();
  const [name, setName] = useState('');
  const [phone, setPhone] = useState('');

  useEffect(() => {
    if (!isAuthenticated) {
      navigate('/shop');
    }
  }, [isAuthenticated, navigate]);

  const handleSubmit = (e: React.FormEvent) => {
    e.preventDefault();
    
    toast({
      title: 'Encomenda enviada!',
      description: 'Receberá um email com os detalhes de pagamento.',
    });
    
    clearCart();
    navigate('/dashboard');
  };

  if (!isAuthenticated) return null;

  return (
    <div className="min-h-screen bg-background">
      <header className="border-b border-border">
        <div className="max-w-7xl mx-auto px-4 py-4">
          <Link to="/dashboard">
            <Button variant="ghost">
              <ArrowLeft className="mr-2 h-4 w-4" />
              Voltar ao Dashboard
            </Button>
          </Link>
        </div>
      </header>

      <div className="max-w-4xl mx-auto px-4 py-12">
        <h1 className="font-serif text-4xl font-bold mb-8 text-foreground">
          Finalizar Encomenda
        </h1>

        {cart.length === 0 ? (
          <div className="text-center py-12">
            <p className="text-muted-foreground text-lg mb-6">
              O seu carrinho está vazio.
            </p>
            <Link to="/dashboard">
              <Button>Voltar aos Álbuns</Button>
            </Link>
          </div>
        ) : (
          <div className="grid md:grid-cols-2 gap-8">
            <div>
              <h2 className="text-2xl font-serif font-bold mb-4 text-foreground">
                Fotos Selecionadas
              </h2>
              <div className="space-y-4">
                {cart.map((item, idx) => (
                  <div key={idx} className="flex gap-4 items-center bg-card border border-border rounded-lg p-3">
                    <img
                      src={item.photoSrc}
                      alt={`Foto ${item.photoIndex + 1}`}
                      className="w-20 h-20 object-cover rounded"
                    />
                    <div className="flex-1">
                      <p className="text-sm text-muted-foreground">
                        Foto {item.photoIndex + 1}
                      </p>
                      <p className="font-semibold text-foreground">€{item.price.toFixed(2)}</p>
                    </div>
                    <Button
                      variant="ghost"
                      size="icon"
                      onClick={() => removeFromCart(item.albumId, item.photoIndex)}
                    >
                      <Trash2 className="h-4 w-4" />
                    </Button>
                  </div>
                ))}
              </div>
              <div className="mt-6 pt-6 border-t border-border">
                <div className="flex justify-between text-xl font-bold">
                  <span>Total:</span>
                  <span>€{totalPrice.toFixed(2)}</span>
                </div>
              </div>
            </div>

            <div>
              <h2 className="text-2xl font-serif font-bold mb-4 text-foreground">
                Dados de Contacto
              </h2>
              <form onSubmit={handleSubmit} className="space-y-6">
                <div className="space-y-2">
                  <Label htmlFor="email">Email</Label>
                  <Input
                    id="email"
                    type="email"
                    value={userEmail || ''}
                    disabled
                  />
                </div>

                <div className="space-y-2">
                  <Label htmlFor="name">Nome Completo *</Label>
                  <Input
                    id="name"
                    type="text"
                    placeholder="O seu nome"
                    value={name}
                    onChange={(e) => setName(e.target.value)}
                    required
                  />
                </div>

                <div className="space-y-2">
                  <Label htmlFor="phone">Telemóvel *</Label>
                  <Input
                    id="phone"
                    type="tel"
                    placeholder="+351 xxx xxx xxx"
                    value={phone}
                    onChange={(e) => setPhone(e.target.value)}
                    required
                  />
                </div>

                <Button type="submit" className="w-full" size="lg">
                  Confirmar Encomenda
                </Button>
              </form>
            </div>
          </div>
        )}
      </div>
    </div>
  );
};

export default Checkout;
