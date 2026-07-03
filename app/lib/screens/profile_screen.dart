import 'package:flutter/material.dart';
import '../constants/app_colors.dart';
import '../constants/app_typography.dart';

class ProfileScreen extends StatelessWidget {
  const ProfileScreen({super.key});

  @override
  Widget build(BuildContext context) {
    return SingleChildScrollView(
      child: Column(
        children: [
          // Profile Header
          Padding(
            padding: const EdgeInsets.symmetric(horizontal: 24.0, vertical: 32),
            child: Column(
              children: [
                const CircleAvatar(
                  radius: 50,
                  backgroundImage: NetworkImage(
                    'https://i.pinimg.com/736x/b8/e9/77/b8e9773a76a28c103e57ae2be23cfc44.jpg',
                  ),
                ),
                const SizedBox(height: 16),
                Text('@elara_vogue', style: AppTypography.heading3),
                const SizedBox(height: 4),
                Text('CREATIVE DIRECTOR', style: AppTypography.caption),
                const SizedBox(height: 24),

                // Stats
                Row(
                  mainAxisAlignment: MainAxisAlignment.spaceEvenly,
                  children: [
                    _statBlock('1.2M', 'FOLLOWERS'),
                    _statBlock('842', 'POSTS'),
                    _statBlock('42k', 'WISHLISTED'),
                  ],
                ),
                const SizedBox(height: 24),

                // Bio
                Text(
                  'Curating the intersection of architectural minimalism and avant-garde luxury. Based in Paris.',
                  textAlign: TextAlign.center,
                  style: AppTypography.bodyMedium.copyWith(
                    color: AppColors.textSecondary,
                    height: 1.5,
                  ),
                ),
                const SizedBox(height: 24),

                // Buttons
                Row(
                  children: [
                    Expanded(
                      child: ElevatedButton(
                        onPressed: () {},
                        style: ElevatedButton.styleFrom(
                          backgroundColor: AppColors.black,
                          foregroundColor: AppColors.white,
                          padding: const EdgeInsets.symmetric(vertical: 12),
                          shape: const RoundedRectangleBorder(
                            borderRadius: BorderRadius.zero,
                          ),
                        ),
                        child: Text('FOLLOW', style: AppTypography.button),
                      ),
                    ),
                    const SizedBox(width: 16),
                    Expanded(
                      child: OutlinedButton(
                        onPressed: () {},
                        style: OutlinedButton.styleFrom(
                          foregroundColor: AppColors.black,
                          side: const BorderSide(color: AppColors.border),
                          padding: const EdgeInsets.symmetric(vertical: 12),
                          shape: const RoundedRectangleBorder(
                            borderRadius: BorderRadius.zero,
                          ),
                        ),
                        child: Text(
                          'MESSAGE',
                          style: AppTypography.button.copyWith(
                            color: AppColors.black,
                          ),
                        ),
                      ),
                    ),
                  ],
                ),
              ],
            ),
          ),

          // Tabs
          Container(
            decoration: const BoxDecoration(
              border: Border(bottom: BorderSide(color: AppColors.border)),
            ),
            child: Row(
              mainAxisAlignment: MainAxisAlignment.spaceEvenly,
              children: [_tab('OUTFITS', true), _tab('WISHLIST', false)],
            ),
          ),

          // Grid
          GridView.count(
            crossAxisCount: 3,
            shrinkWrap: true,
            physics: const NeverScrollableScrollPhysics(),
            mainAxisSpacing: 2,
            crossAxisSpacing: 2,
            childAspectRatio: 1.0,
            children: [
              _gridImage(
                'https://images.unsplash.com/photo-1515886657613-9f3515b0c78f?w=400&q=80',
              ),
              _gridImage(
                'https://images.unsplash.com/photo-1483985988355-763728e1935b?w=400&q=80',
              ),
              _gridImage(
                'https://images.unsplash.com/photo-1584916201218-f4242ceb4809?w=400&q=80',
              ),
              _gridImage(
                'https://images.unsplash.com/photo-1595777457583-95e059d581b8?w=400&q=80',
              ),
              _gridImage(
                'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=400&q=80',
              ),
              _gridImage(
                'https://images.unsplash.com/photo-1548036328-c9fa89d128fa?w=400&q=80',
              ),
            ],
          ),
        ],
      ),
    );
  }

  Widget _statBlock(String value, String label) {
    return Column(
      children: [
        Text(value, style: AppTypography.heading3.copyWith(fontSize: 20)),
        Text(label, style: AppTypography.caption.copyWith(fontSize: 10)),
      ],
    );
  }

  Widget _tab(String title, bool isSelected) {
    return Expanded(
      child: Container(
        padding: const EdgeInsets.symmetric(vertical: 16),
        decoration: BoxDecoration(
          border: Border(
            bottom: BorderSide(
              color: isSelected ? AppColors.black : Colors.transparent,
              width: 2,
            ),
          ),
        ),
        alignment: Alignment.center,
        child: Text(
          title,
          style: AppTypography.caption.copyWith(
            color: isSelected ? AppColors.black : AppColors.textSecondary,
            fontWeight: isSelected ? FontWeight.w700 : FontWeight.w500,
          ),
        ),
      ),
    );
  }

  Widget _gridImage(String url) {
    return Container(
      decoration: BoxDecoration(
        color: AppColors.background,
        image: DecorationImage(image: NetworkImage(url), fit: BoxFit.cover),
      ),
    );
  }
}
