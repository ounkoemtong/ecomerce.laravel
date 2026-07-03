import '../models/product.dart';

class MockDataService {
  static List<Product> get newArrivals => [
    Product(
      id: '1',
      name: 'NIGHT SILK DRESS',
      description: 'Essential Series',
      price: 240,
      imageUrl:
          'https://i.pinimg.com/1200x/9f/d8/35/9fd835e13d85b66bee3ea3df75d0d8bf.jpg',
      category: 'Women',
    ),
    Product(
      id: '2',
      name: 'STRUCTURED WOOL COAT',
      description: 'Winter \'24',
      price: 1490,
      imageUrl:
          'https://i.pinimg.com/1200x/ce/2d/4c/ce2d4c572169c66c9b9cf1fa62d12c9b.jpg',
      category: 'Men',
    ),
    Product(
      id: '3',
      name: 'SCULPTURAL LEATHER BOOT',
      description: 'Footwear',
      price: 620,
      imageUrl:
          'https://i.pinimg.com/736x/ea/3e/08/ea3e08ca0edac942f63552aff1757f6d.jpg',
      category: 'Men',
    ),
    Product(
      id: '4',
      name: 'ORBITAL PENDANT',
      description: 'Silver 925',
      price: 180,
      imageUrl:
          'https://i.pinimg.com/736x/2e/25/8a/2e258a96b2294ac153264d7a967c17ee.jpg',
      category: 'Accessories',
    ),
  ];

  static List<Product> get trendingProducts => [
    Product(
      id: '5',
      name: 'Oversized Wool Blazer',
      description: 'ATELIER LUXE',
      price: 890,
      imageUrl:
          'https://i.pinimg.com/1200x/40/0f/13/400f13c201cdb8f0dce30c0914aef482.jpg',
      category: 'Men',
    ),
    Product(
      id: '6',
      name: 'Pleated Silk Trousers',
      description: 'NEW ARRIVAL',
      price: 520,
      imageUrl:
          'https://i.pinimg.com/736x/27/8c/ab/278cabcc30624538662c9409417f6b50.jpg',
      category: 'Women',
    ),
    Product(
      id: '7',
      name: 'Sculptural Leather Loafers',
      description: 'BEST SELLER',
      price: 550,
      imageUrl:
          'https://i.pinimg.com/736x/7d/c5/63/7dc56380074f212a9af6833a1040134c.jpg',
      category: 'Men',
    ),
    Product(
      id: '8',
      name: 'Sterling Silver Cuff',
      description: 'LIMITED EDITION',
      price: 280,
      imageUrl:
          'https://i.pinimg.com/736x/f3/fb/ac/f3fbacee2ebada21395d358b8c77871d.jpg',
      category: 'Accessories',
    ),
  ];

  static Product get productDetail => Product(
    id: '2',
    name: 'SCULPTURAL WOOL OVERCOAT',
    description:
        'Crafted from 100% heavy-weight virgin wool, this sculptural overcoat defines modern luxury. Featuring structured architectural shoulders, a clean concealed placket, and hand-finished seams. A cornerstone of the Atelier core collection.',
    price: 1490.00,
    imageUrl:
        'https://i.pinimg.com/736x/d6/f9/b4/d6f9b4540951264600b205ddadca19ac.jpg',
    category: 'OUTERWEAR / COATS',
    availableColors: ['#000000', '#2C3539', '#DCDCDC'], // Noir, Charcoal, Grey
    availableSizes: ['XS', 'S', 'M', 'L'],
  );

  static List<Product> get completeTheLook => [
    Product(
      id: '3',
      name: 'SMART LEATHER BOOT',
      description: '',
      price: 420.00,
      imageUrl:
          'https://i.pinimg.com/736x/15/b0/c0/15b0c0548e146c9b28c7c6eb2d828b43.jpg',
      category: 'Men',
    ),
    Product(
      id: '9',
      name: 'TAILORED WOOL TROUSER',
      description: '',
      price: 340.00,
      imageUrl:
          'https://i.pinimg.com/736x/4e/73/70/4e73701b2ea56b2e460d99c1f1d70e1c.jpg',
      category: 'Men',
    ),
    Product(
      id: '10',
      name: 'CASHMERE TURTLENECK',
      description: '',
      price: 380.00,
      imageUrl:
          'https://i.pinimg.com/736x/f2/c2/83/f2c283c3ba36cc72dc2bbd4c42d180d5.jpg',
      category: 'Men',
    ),
    Product(
      id: '11',
      name: 'ARTISAN TOTE BAG',
      description: '',
      price: 850.00,
      imageUrl:
          'https://i.pinimg.com/736x/47/b5/ab/47b5abbf77a356731f52344105b84205.jpg',
      category: 'Accessories',
    ),
  ];
}
