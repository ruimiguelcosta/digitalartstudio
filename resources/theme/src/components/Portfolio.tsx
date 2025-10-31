import { albums } from "@/data/albums";
import { Link } from "react-router-dom";

const Portfolio = () => {
  return (
    <section id="portfolio" className="py-24 px-4 bg-secondary">
      <div className="max-w-6xl mx-auto">
        <h2 className="font-serif text-4xl md:text-5xl font-bold text-center mb-16 text-foreground">
          Portfolio
        </h2>
        <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
          {albums.map((album) => (
            <Link 
              key={album.id}
              to={`/album/${album.id}`}
              className="relative overflow-hidden rounded-lg aspect-[4/5] group cursor-pointer"
            >
              <img 
                src={album.coverPhoto} 
                alt={album.title}
                className="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110"
              />
              <div className="absolute inset-0 bg-gradient-to-t from-background/80 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-end">
                <h3 className="font-serif text-2xl font-bold text-foreground p-6">
                  {album.title}
                </h3>
              </div>
            </Link>
          ))}
        </div>
      </div>
    </section>
  );
};

export default Portfolio;
