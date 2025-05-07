tailwind.config = {
    theme: {
        extend: {
            colors: {
                primary: {
                    DEFAULT: "#9E0000FF",
                    dark: "#6B0000",
                    light: "#AB0000",
                },
                secondary: {
                    DEFAULT: "#2C3E50",
                    dark: "#1C2E40",
                    light: "#3C4E60",
                },
                accent: "#F39C12",
                success: "#27AE60",
                warning: "#F39C12",
                danger: "#E74C3C",
                info: "#3498DB",
                card: {
                    DEFAULT: "#FFFFFF",
                    dark: "#F8FAFC",
                },
            },
            boxShadow: {
                card: "0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03)",
                "card-hover":
                    "0 10px 15px -3px rgba(0, 0, 0, 0.08), 0 4px 6px -2px rgba(0, 0, 0, 0.04)",
            },
        },
    },
};
