import 'package:flutter/material.dart';
import '../constants/app_colors.dart';
import '../constants/app_typography.dart';
import '../widgets/app_drawer.dart';
import 'home_screen.dart';
import 'shop_screen.dart';
import 'profile_screen.dart';
import 'placeholder_screen.dart';
import '../widgets/cart_drawer.dart';
import 'wishlist_screen.dart';
import '../services/app_state.dart';
import '../models/product.dart';

class MainLayout extends StatefulWidget {
  const MainLayout({super.key});

  @override
  State<MainLayout> createState() => _MainLayoutState();
}

class _MainLayoutState extends State<MainLayout> {
  int _currentIndex = 0;

  final List<Widget> _screens = [
    const HomeScreen(),
    const ShopScreen(),
    const ProfileScreen(),
  ];

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      drawer: const AppDrawer(),
      endDrawer: const CartDrawer(),
      appBar: AppBar(
        backgroundColor: AppColors.white,
        elevation: 0,
        centerTitle: true,
        leading: Builder(
          builder: (context) {
            return IconButton(
              icon: const Icon(Icons.menu, color: AppColors.black),
              onPressed: () {
                Scaffold.of(context).openDrawer();
              },
            );
          }
        ),
        title: Text(
          'ATELIER',
          style: AppTypography.heading2.copyWith(fontSize: 20, letterSpacing: 2),
        ),
        actions: [
          ValueListenableBuilder<List<Product>>(
            valueListenable: AppState().wishlistItems,
            builder: (context, wishlist, child) {
              return IconButton(
                icon: Badge(
                  isLabelVisible: wishlist.isNotEmpty,
                  label: Text(wishlist.length.toString()),
                  child: const Icon(Icons.favorite_border, color: AppColors.black),
                ),
                onPressed: () {
                  Navigator.push(
                    context,
                    MaterialPageRoute(builder: (_) => const WishlistScreen()),
                  );
                },
              );
            },
          ),
          Builder(
            builder: (context) {
              return ValueListenableBuilder<List<Product>>(
                valueListenable: AppState().cartItems,
                builder: (context, cart, child) {
                  return IconButton(
                    icon: Badge(
                      isLabelVisible: cart.isNotEmpty,
                      label: Text(cart.length.toString()),
                      child: const Icon(Icons.shopping_bag_outlined, color: AppColors.black),
                    ),
                    onPressed: () {
                      Scaffold.of(context).openEndDrawer();
                    },
                  );
                },
              );
            }
          ),
          const SizedBox(width: 8),
        ],
      ),
      body: _screens[_currentIndex],
      bottomNavigationBar: BottomNavigationBar(
        currentIndex: _currentIndex,
        onTap: (index) {
          setState(() {
            _currentIndex = index;
          });
        },
        backgroundColor: AppColors.white,
        selectedItemColor: AppColors.black,
        unselectedItemColor: AppColors.textSecondary,
        showSelectedLabels: true,
        showUnselectedLabels: true,
        type: BottomNavigationBarType.fixed,
        selectedLabelStyle: AppTypography.caption.copyWith(fontWeight: FontWeight.w600),
        unselectedLabelStyle: AppTypography.caption,
        items: const [
          BottomNavigationBarItem(
            icon: Icon(Icons.home_outlined),
            activeIcon: Icon(Icons.home),
            label: 'Home',
          ),
          BottomNavigationBarItem(
            icon: Icon(Icons.grid_view_outlined),
            activeIcon: Icon(Icons.grid_view),
            label: 'Shop',
          ),
          BottomNavigationBarItem(
            icon: Icon(Icons.person_outline),
            activeIcon: Icon(Icons.person),
            label: 'Profile',
          ),
        ],
      ),
    );
  }
}
