import 'package:flutter/material.dart';
import '../constants/app_colors.dart';
import '../constants/app_typography.dart';
import '../screens/placeholder_screen.dart';
import '../screens/category_screen.dart';
import '../screens/wishlist_screen.dart';

class AppDrawer extends StatelessWidget {
  const AppDrawer({super.key});

  @override
  Widget build(BuildContext context) {
    return Drawer(
      backgroundColor: AppColors.white,
      child: SafeArea(
        child: Column(
          crossAxisAlignment: CrossAxisAlignment.start,
          children: [
            // Close button and Logo
            Padding(
              padding: const EdgeInsets.symmetric(horizontal: 16.0, vertical: 8.0),
              child: Row(
                mainAxisAlignment: MainAxisAlignment.spaceBetween,
                children: [
                  Text('ATELIER', style: AppTypography.heading2.copyWith(fontSize: 24, letterSpacing: 2)),
                  IconButton(
                    icon: const Icon(Icons.close, color: AppColors.black),
                    onPressed: () => Navigator.pop(context),
                  ),
                ],
              ),
            ),
            const SizedBox(height: 24),
            
            // Search
            Padding(
              padding: const EdgeInsets.symmetric(horizontal: 24.0),
              child: TextField(
                decoration: InputDecoration(
                  hintText: 'Search Collection',
                  hintStyle: AppTypography.bodyMedium.copyWith(color: AppColors.textSecondary),
                  prefixIcon: const Icon(Icons.search, color: AppColors.black, size: 20),
                  enabledBorder: const UnderlineInputBorder(borderSide: BorderSide(color: AppColors.border)),
                  focusedBorder: const UnderlineInputBorder(borderSide: BorderSide(color: AppColors.black)),
                ),
              ),
            ),
            const SizedBox(height: 40),

            // Navigation Links
            Expanded(
              child: ListView(
                padding: const EdgeInsets.symmetric(horizontal: 24.0),
                children: [
                  _drawerItem(context, 'Women'),
                  _drawerItem(context, 'Men'),
                  _drawerItem(context, 'Accessories'),
                  _drawerItem(context, 'Shoes'),
                  const SizedBox(height: 40),
                  const Divider(color: AppColors.border),
                  const SizedBox(height: 24),
                  _drawerItem(context, 'My Account', isSmall: true),
                  _drawerItem(context, 'Wishlist', isSmall: true),
                  _drawerItem(context, 'Customer Service', isSmall: true),
                ],
              ),
            ),
          ],
        ),
      ),
    );
  }

  Widget _drawerItem(BuildContext context, String title, {bool isSmall = false}) {
    return Padding(
      padding: const EdgeInsets.only(bottom: 24.0),
      child: InkWell(
        onTap: () {
          Navigator.pop(context); // Close drawer
          Widget destination;
          if (title == 'Women' || title == 'Men' || title == 'Accessories' || title == 'Shoes') {
            destination = CategoryScreen(categoryName: title);
          } else if (title == 'Wishlist') {
            destination = const WishlistScreen();
          } else {
            destination = PlaceholderScreen(title: title);
          }
          Navigator.push(
            context,
            MaterialPageRoute(builder: (_) => destination),
          );
        },
        child: Text(
          title,
          style: isSmall 
              ? AppTypography.bodyMedium 
              : AppTypography.heading3.copyWith(fontSize: 24),
        ),
      ),
    );
  }
}
