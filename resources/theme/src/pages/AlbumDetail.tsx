import { useParams, Link } from "react-router-dom";
import { albums } from "@/data/albums";
import { ArrowLeft } from "lucide-react";
import { Button } from "@/components/ui/button";
import {
  Carousel,
  CarouselContent,
  CarouselItem,
  CarouselNext,
  CarouselPrevious,
} from "@/components/ui/carousel";

const AlbumDetail = () => {
  const { id } = useParams();
  const album = albums.find((a) => a.id === id);

  if (!album) {
    return (
      <div className="min-h-screen bg-background flex items-center justify-center px-4">
        <div className="text-center">
          <h1 className="text-4xl font-serif font-bold mb-4 text-foreground">Álbum não encontrado</h1>
          <Link to="/">
            <Button variant="outline">
              <ArrowLeft className="mr-2 h-4 w-4" />
              Voltar ao início
            </Button>
          </Link>
        </div>
      </div>
    );
  }

  return (
    <div className="min-h-screen bg-background">
      <div className="max-w-6xl mx-auto px-4 py-12">
        <Link to="/#portfolio">
          <Button variant="ghost" className="mb-8">
            <ArrowLeft className="mr-2 h-4 w-4" />
            Voltar ao Portfolio
          </Button>
        </Link>

        <h1 className="font-serif text-4xl md:text-5xl font-bold mb-4 text-foreground">
          {album.title}
        </h1>
        <p className="text-lg text-muted-foreground mb-12 max-w-3xl">
          {album.description}
        </p>

        <Carousel className="w-full">
          <CarouselContent>
            {album.photos.map((photo, index) => (
              <CarouselItem key={index}>
                <div className="relative aspect-[16/10] overflow-hidden rounded-lg">
                  <img
                    src={photo.src}
                    alt={photo.alt}
                    className="w-full h-full object-cover"
                  />
                </div>
              </CarouselItem>
            ))}
          </CarouselContent>
          <CarouselPrevious className="left-4" />
          <CarouselNext className="right-4" />
        </Carousel>
      </div>
    </div>
  );
};

export default AlbumDetail;
