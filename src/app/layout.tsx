import type { Metadata } from "next";
import { Inter } from "next/font/google";
import "./globals.css";
import { APP_NAME, DESCRIPTION } from "@/lib/constants/index";

const inter = Inter({
  subsets: ["latin"]
})

export const metadata: Metadata = {
  title: APP_NAME,
  description: DESCRIPTION,
};

export default function RootLayout({
  children,
}: Readonly<{
  children: React.ReactNode;
}>) {
  return (
    <html lang="en">
      <body
        className={`${inter.className} antialiased`}
      >
        {children}
      </body>
    </html>
  );
}
