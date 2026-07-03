import 'package:flutter/foundation.dart';
import '../models/product.dart';

class AppState {
  static final AppState _instance = AppState._internal();
  factory AppState() => _instance;
  AppState._internal();

  final ValueNotifier<List<Product>> cartItems = ValueNotifier([]);
  final ValueNotifier<List<Product>> wishlistItems = ValueNotifier([]);

  void addToCart(Product product) {
    if (!cartItems.value.contains(product)) {
      cartItems.value = [...cartItems.value, product];
    }
  }

  void removeFromCart(Product product) {
    cartItems.value = cartItems.value.where((p) => p.id != product.id).toList();
  }

  void toggleWishlist(Product product) {
    final currentList = wishlistItems.value;
    if (currentList.any((p) => p.id == product.id)) {
      wishlistItems.value = currentList.where((p) => p.id != product.id).toList();
    } else {
      wishlistItems.value = [...currentList, product];
    }
  }

  bool isInWishlist(Product product) {
    return wishlistItems.value.any((p) => p.id == product.id);
  }
}
