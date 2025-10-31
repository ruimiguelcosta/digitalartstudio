export interface DashboardAlbum {
  id: string;
  title: string;
  description: string;
  coverPhoto: string;
  photos: string[];
  clientEmail: string; // Email do cliente que pode ver este álbum
}

// Dados mockados - em produção viriam do backend
export const dashboardAlbums: DashboardAlbum[] = [
  {
    id: 'casamento-silva-2024',
    title: 'Casamento Silva - Janeiro 2024',
    description: 'Fotografias do vosso dia especial. Escolham as vossas favoritas!',
    coverPhoto: 'https://images.unsplash.com/photo-1519741497674-611481863552?auto=format&fit=crop&w=800',
    clientEmail: 'cliente@exemplo.com',
    photos: [
      'https://images.unsplash.com/photo-1519741497674-611481863552?auto=format&fit=crop&w=1200',
      'https://images.unsplash.com/photo-1606800052052-a08af7148866?auto=format&fit=crop&w=1200',
      'https://images.unsplash.com/photo-1591604466107-ec97de577aff?auto=format&fit=crop&w=1200',
      'https://images.unsplash.com/photo-1465495976277-4387d4b0b4c6?auto=format&fit=crop&w=1200',
      'https://images.unsplash.com/photo-1511285560929-80b456fea0bc?auto=format&fit=crop&w=1200',
      'https://images.unsplash.com/photo-1583939003579-730e3918a45a?auto=format&fit=crop&w=1200',
      'https://images.unsplash.com/photo-1522413452208-996ff3f3e740?auto=format&fit=crop&w=1200',
      'https://images.unsplash.com/photo-1545291730-faff8ca1d4b0?auto=format&fit=crop&w=1200',
    ]
  },
  {
    id: 'aniversario-maria-2024',
    title: 'Aniversário Maria - Fevereiro 2024',
    description: 'Momentos especiais da festa de aniversário.',
    coverPhoto: 'https://images.unsplash.com/photo-1530103862676-de8c9debad1d?auto=format&fit=crop&w=800',
    clientEmail: 'cliente@exemplo.com',
    photos: [
      'https://images.unsplash.com/photo-1530103862676-de8c9debad1d?auto=format&fit=crop&w=1200',
      'https://images.unsplash.com/photo-1464349095431-e9a21285b5f3?auto=format&fit=crop&w=1200',
      'https://images.unsplash.com/photo-1558636508-e0db3814bd1d?auto=format&fit=crop&w=1200',
      'https://images.unsplash.com/photo-1513151233558-d860c5398176?auto=format&fit=crop&w=1200',
      'https://images.unsplash.com/photo-1569517282132-25d22f4573e6?auto=format&fit=crop&w=1200',
    ]
  },
  {
    id: 'evento-teste',
    title: 'Evento Teste',
    description: 'Álbum de teste para demonstração.',
    coverPhoto: 'https://images.unsplash.com/photo-1492684223066-81342ee5ff30?auto=format&fit=crop&w=800',
    clientEmail: 'teste@teste.com',
    photos: [
      'https://images.unsplash.com/photo-1492684223066-81342ee5ff30?auto=format&fit=crop&w=1200',
      'https://images.unsplash.com/photo-1470229538611-16ba8c7ffbd7?auto=format&fit=crop&w=1200',
      'https://images.unsplash.com/photo-1505236858219-8359eb29e329?auto=format&fit=crop&w=1200',
    ]
  }
];
