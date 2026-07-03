import 'package:flutter/material.dart';
import '../constants/app_colors.dart';
import '../constants/app_typography.dart';
import '../services/app_state.dart';
import '../models/product.dart';
import '../services/telegram_service.dart';
import '../utils/toast_utils.dart';

class CartDrawer extends StatelessWidget {
  const CartDrawer({super.key});

  @override
  Widget build(BuildContext context) {
    return Drawer(
      backgroundColor: AppColors.white,
      child: SafeArea(
        child: Column(
          crossAxisAlignment: CrossAxisAlignment.start,
          children: [
            Padding(
              padding: const EdgeInsets.symmetric(horizontal: 16.0, vertical: 8.0),
              child: Row(
                mainAxisAlignment: MainAxisAlignment.spaceBetween,
                children: [
                  Text('YOUR CART', style: AppTypography.heading2.copyWith(fontSize: 20)),
                  IconButton(
                    icon: const Icon(Icons.close, color: AppColors.black),
                    onPressed: () => Navigator.pop(context),
                  ),
                ],
              ),
            ),
            const Divider(color: AppColors.border),
            Expanded(
              child: ValueListenableBuilder<List<Product>>(
                valueListenable: AppState().cartItems,
                builder: (context, cart, child) {
                  if (cart.isEmpty) {
                    return Center(
                      child: Text(
                        'Your cart is empty',
                        style: AppTypography.bodyMedium,
                      ),
                    );
                  }
                  return ListView.builder(
                    itemCount: cart.length,
                    itemBuilder: (context, index) {
                      final product = cart[index];
                      return Padding(
                        padding: const EdgeInsets.symmetric(horizontal: 16.0, vertical: 12.0),
                        child: Row(
                          children: [
                            Container(
                              width: 80,
                              height: 100,
                              color: AppColors.background,
                              child: Image.network(
                                product.imageUrl,
                                fit: BoxFit.cover,
                                errorBuilder: (context, error, stackTrace) =>
                                    const Icon(Icons.image_not_supported, color: Colors.grey),
                              ),
                            ),
                            const SizedBox(width: 16),
                            Expanded(
                              child: Column(
                                crossAxisAlignment: CrossAxisAlignment.start,
                                children: [
                                  Text(
                                    product.name,
                                    style: AppTypography.bodyMedium.copyWith(fontWeight: FontWeight.w600),
                                    maxLines: 2,
                                    overflow: TextOverflow.ellipsis,
                                  ),
                                  const SizedBox(height: 8),
                                  Text('\$${product.price.toStringAsFixed(0)}', style: AppTypography.bodyMedium),
                                ],
                              ),
                            ),
                            IconButton(
                              icon: const Icon(Icons.delete_outline, color: AppColors.textSecondary),
                              onPressed: () {
                                AppState().removeFromCart(product);
                              },
                            )
                          ],
                        ),
                      );
                    },
                  );
                },
              ),
            ),
            const Divider(color: AppColors.border),
            Padding(
              padding: const EdgeInsets.all(24.0),
              child: Column(
                children: [
                  ValueListenableBuilder<List<Product>>(
                    valueListenable: AppState().cartItems,
                    builder: (context, cart, child) {
                      final total = cart.fold(0.0, (sum, item) => sum + item.price);
                      return Row(
                        mainAxisAlignment: MainAxisAlignment.spaceBetween,
                        children: [
                          Text('TOTAL', style: AppTypography.heading3),
                          Text('\$${total.toStringAsFixed(0)}', style: AppTypography.heading3),
                        ],
                      );
                    },
                  ),
                  const SizedBox(height: 24),
                  SizedBox(
                    width: double.infinity,
                    child: ElevatedButton(
                      onPressed: () async {
                        final items = AppState().cartItems.value;
                        if (items.isEmpty) return;

                        final total = items.fold(0.0, (sum, item) => sum + item.price);
                        
                        // Show loading or just send
                        final status = await TelegramService.sendCheckoutMessage(items, total);
                        
                        if (context.mounted) {
                          if (status == 'OK') {
                            AppState().cartItems.value = []; // Clear cart
                            Navigator.pop(context); // Close drawer
                            ToastUtils.showTopRightToast(context, 'Order placed successfully! Check Telegram.', durationMs: 1500);
                          } else {
                            ToastUtils.showTopRightToast(context, 'Failed: $status', isSuccess: false, durationMs: 2500);
                          }
                        }
                      },
                      style: ElevatedButton.styleFrom(
                        backgroundColor: AppColors.black,
                        foregroundColor: AppColors.white,
                        padding: const EdgeInsets.symmetric(vertical: 16),
                        shape: const RoundedRectangleBorder(borderRadius: BorderRadius.zero),
                      ),
                      child: Text('CHECKOUT', style: AppTypography.button),
                    ),
                  ),
                ],
              ),
            ),
          ],
        ),
      ),
    );
  }
}
