import { useEffect, useState, useRef } from "react";
import { useNavigate, useParams } from "react-router-dom";
import { Button } from "@/components/ui/button";
import { Card, CardContent } from "@/components/ui/card";
import { useToast } from "@/hooks/use-toast";
import { Badge } from "@/components/ui/badge";
import { ArrowLeft, Camera, Upload, Trash2, Image as ImageIcon, Send } from "lucide-react";

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

interface Photo {
  id: string;
  albumId: string;
  dataUrl: string;
  uploadedAt: string;
}

const AlbumDetail = () => {
  const { id } = useParams();
  const [album, setAlbum] = useState<Album | null>(null);
  const [photos, setPhotos] = useState<Photo[]>([]);
  const [isUploading, setIsUploading] = useState(false);
  const fileInputRef = useRef<HTMLInputElement>(null);
  const navigate = useNavigate();
  const { toast } = useToast();

  useEffect(() => {
    const session = localStorage.getItem("photographer_session");
    if (!session) {
      navigate("/auth");
      return;
    }

    // Load album
    const savedAlbums = localStorage.getItem("albums");
    if (savedAlbums) {
      const albums = JSON.parse(savedAlbums);
      const currentAlbum = albums.find((a: Album) => a.id === id);
      if (currentAlbum) {
        setAlbum(currentAlbum);
      }
    }

    // Load photos for this album
    const savedPhotos = localStorage.getItem(`photos_${id}`);
    if (savedPhotos) {
      setPhotos(JSON.parse(savedPhotos));
    }
  }, [id, navigate]);

  const handleFileSelect = async (e: React.ChangeEvent<HTMLInputElement>) => {
    const files = e.target.files;
    if (!files || !id) return;

    setIsUploading(true);
    const newPhotos: Photo[] = [];

    for (let i = 0; i < files.length; i++) {
      const file = files[i];
      const reader = new FileReader();

      await new Promise<void>((resolve) => {
        reader.onload = (event) => {
          const photo: Photo = {
            id: `${Date.now()}_${i}`,
            albumId: id,
            dataUrl: event.target?.result as string,
            uploadedAt: new Date().toISOString(),
          };
          newPhotos.push(photo);
          resolve();
        };
        reader.readAsDataURL(file);
      });
    }

    const updatedPhotos = [...photos, ...newPhotos];
    setPhotos(updatedPhotos);
    localStorage.setItem(`photos_${id}`, JSON.stringify(updatedPhotos));

    // Update album photo count and cover image
    if (album) {
      const updatedAlbum = {
        ...album,
        photoCount: updatedPhotos.length,
        coverImage: updatedPhotos[0]?.dataUrl || album.coverImage,
      };
      
      const savedAlbums = localStorage.getItem("albums");
      if (savedAlbums) {
        const albums = JSON.parse(savedAlbums);
        const updatedAlbums = albums.map((a: Album) =>
          a.id === id ? updatedAlbum : a
        );
        localStorage.setItem("albums", JSON.stringify(updatedAlbums));
        setAlbum(updatedAlbum);
      }
    }

    toast({
      title: "Upload concluído!",
      description: `${newPhotos.length} ${newPhotos.length === 1 ? 'foto adicionada' : 'fotos adicionadas'} ao álbum.`,
    });

    setIsUploading(false);
    if (fileInputRef.current) {
      fileInputRef.current.value = "";
    }
  };

  const handleDeletePhoto = (photoId: string) => {
    const updatedPhotos = photos.filter((p) => p.id !== photoId);
    setPhotos(updatedPhotos);
    localStorage.setItem(`photos_${id}`, JSON.stringify(updatedPhotos));

    // Update album photo count
    if (album) {
      const updatedAlbum = {
        ...album,
        photoCount: updatedPhotos.length,
      };
      
      const savedAlbums = localStorage.getItem("albums");
      if (savedAlbums) {
        const albums = JSON.parse(savedAlbums);
        const updatedAlbums = albums.map((a: Album) =>
          a.id === id ? updatedAlbum : a
        );
        localStorage.setItem("albums", JSON.stringify(updatedAlbums));
        setAlbum(updatedAlbum);
      }
    }

    toast({
      title: "Foto eliminada",
      description: "A foto foi removida do álbum.",
    });
  };

  const handlePublish = () => {
    if (!album) return;

    const updatedAlbum = {
      ...album,
      status: "published" as const,
    };

    const savedAlbums = localStorage.getItem("albums");
    if (savedAlbums) {
      const albums = JSON.parse(savedAlbums);
      const updatedAlbums = albums.map((a: Album) =>
        a.id === id ? updatedAlbum : a
      );
      localStorage.setItem("albums", JSON.stringify(updatedAlbums));
      setAlbum(updatedAlbum);
    }

    toast({
      title: "Álbum publicado!",
      description: "O álbum está agora visível para os clientes.",
    });
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
          <div className="flex items-center gap-4">
            <Button
              variant="ghost"
              size="icon"
              onClick={() => navigate("/dashboard")}
            >
              <ArrowLeft className="w-5 h-5" />
            </Button>
            <div className="flex items-center gap-3 flex-1">
              <div className="w-10 h-10 rounded-xl bg-gradient-to-br from-primary to-accent flex items-center justify-center">
                <Camera className="w-5 h-5 text-primary-foreground" />
              </div>
              <div className="flex-1">
                <div className="flex items-center gap-2 mb-1">
                  <h1 className="text-xl font-bold">{album.title}</h1>
                  <Badge variant={album.status === "published" ? "default" : "secondary"}>
                    {album.status === "published" ? "Publicado" : "Rascunho"}
                  </Badge>
                </div>
                <p className="text-sm text-muted-foreground">
                  {new Date(album.date).toLocaleDateString('pt-PT')} • {photos.length} {photos.length === 1 ? 'foto' : 'fotos'}
                </p>
              </div>
            </div>
            <div className="flex gap-2">
              <input
                ref={fileInputRef}
                type="file"
                multiple
                accept="image/*"
                onChange={handleFileSelect}
                className="hidden"
              />
              {album.status === "draft" && (
                <Button
                  variant="outline"
                  onClick={handlePublish}
                  className="gap-2"
                >
                  <Send className="w-4 h-4" />
                  Publicar
                </Button>
              )}
              <Button
                onClick={() => fileInputRef.current?.click()}
                disabled={isUploading}
                className="gap-2"
              >
                <Upload className="w-4 h-4" />
                {isUploading ? "A enviar..." : "Upload Fotos"}
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
              <ImageIcon className="w-16 h-16 text-muted-foreground/50 mb-4" />
              <h3 className="text-xl font-semibold mb-2">Nenhuma foto no álbum</h3>
              <p className="text-muted-foreground text-center mb-6 max-w-md">
                Faça upload das fotos do evento para começar
              </p>
              <Button onClick={() => fileInputRef.current?.click()}>
                <Upload className="w-4 h-4 mr-2" />
                Upload Fotos
              </Button>
            </CardContent>
          </Card>
        ) : (
          <div className="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
            {photos.map((photo) => (
              <Card
                key={photo.id}
                className="group overflow-hidden border-border/50 hover:shadow-lg transition-all duration-300"
              >
                <div className="aspect-square relative">
                  <img
                    src={photo.dataUrl}
                    alt="Event photo"
                    className="w-full h-full object-cover"
                  />
                  <div className="absolute inset-0 bg-black/60 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                    <Button
                      size="icon"
                      variant="destructive"
                      onClick={() => handleDeletePhoto(photo.id)}
                    >
                      <Trash2 className="w-4 h-4" />
                    </Button>
                  </div>
                </div>
              </Card>
            ))}
          </div>
        )}
      </main>
    </div>
  );
};

export default AlbumDetail;
