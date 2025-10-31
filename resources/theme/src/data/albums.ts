import weddingPhoto from "@/assets/wedding-photo.jpg";
import dancePhoto from "@/assets/dance-photo.jpg";
import theaterPhoto from "@/assets/theater-photo.jpg";
import partyPhoto from "@/assets/party-photo.jpg";

export interface Album {
  id: string;
  title: string;
  description: string;
  coverPhoto: string;
  photos: { src: string; alt: string }[];
}

export const albums: Album[] = [
  {
    id: "casamentos",
    title: "Casamentos",
    description: "Momentos únicos e inesquecíveis do dia mais importante das vossas vidas. Cada fotografia conta uma história de amor, emoção e celebração.",
    coverPhoto: weddingPhoto,
    photos: [
      { src: weddingPhoto, alt: "Fotografia de casamento - Cerimônia" },
      { src: weddingPhoto, alt: "Fotografia de casamento - Noivos" },
      { src: weddingPhoto, alt: "Fotografia de casamento - Festa" },
    ]
  },
  {
    id: "danca",
    title: "Dança",
    description: "Capturando o movimento, a expressão e a energia dos bailarinos. Cada imagem revela a arte em movimento e a paixão pela dança.",
    coverPhoto: dancePhoto,
    photos: [
      { src: dancePhoto, alt: "Fotografia de dança - Performance" },
      { src: dancePhoto, alt: "Fotografia de dança - Ensaio" },
      { src: dancePhoto, alt: "Fotografia de dança - Espetáculo" },
    ]
  },
  {
    id: "teatro",
    title: "Teatro",
    description: "Registando a magia do palco, a intensidade dramática e os momentos únicos das produções teatrais.",
    coverPhoto: theaterPhoto,
    photos: [
      { src: theaterPhoto, alt: "Fotografia de teatro - Cena dramática" },
      { src: theaterPhoto, alt: "Fotografia de teatro - Atores em cena" },
      { src: theaterPhoto, alt: "Fotografia de teatro - Momento especial" },
    ]
  },
  {
    id: "festas",
    title: "Festas",
    description: "Celebrações cheias de alegria, diversão e memórias especiais. Capturo a energia e os momentos únicos de cada evento.",
    coverPhoto: partyPhoto,
    photos: [
      { src: partyPhoto, alt: "Fotografia de festa - Celebração" },
      { src: partyPhoto, alt: "Fotografia de festa - Diversão" },
      { src: partyPhoto, alt: "Fotografia de festa - Momento especial" },
    ]
  }
];
